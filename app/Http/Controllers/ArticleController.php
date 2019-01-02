<?php

namespace App\Http\Controllers;

use App\Column;
use App\tag;
use Illuminate\Http\Request;
use \App\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    //获取文章列表
    public function show()
    {
        $res = Article::with('tags', 'column')->orderBy('created_at', 'desc')->get();
        return $res;
    }
    public function hot(){
        $res = Article::orderBy('created_at', 'desc')->get();
        return $res;
    }
    public function artList()
    {
        $res = Article::withCount('comments')->with( 'column', 'user')->orderBy('created_at', 'desc')->simplePaginate(2);
        return $res;
    }
    public function columnArtList(Request $request){
        $ele = array_slice(explode('/',$request->path()),-1,1);
        $res = Column::where('remark',$ele[0])->get();
        $res = Article::where('column_id',$res[0]['id'])->withCount('comments')->with( 'column', 'user')->orderBy('created_at', 'desc')->simplePaginate(2);
        return $res;
    }
    public function tagArtList(){
        $article = Article::with('user','tags')->orderBy('created_at', 'desc')->get();
        dd($article);
    }
    public function nextPage(){
    }
    public function details($id)
    {
        $article = Article::with('user','tags')->orderBy('created_at', 'desc')->find($id);
        $arr = $article->toArray();
        $arr['is_zan'] = Auth::check()?$article->isUpVotedBy(Auth::user()):false;
        return $arr;
    }

    public function getArticleData()
    {
        $column = \App\Column::orderBy('created_at', 'desc')->get();
        $tag = \App\tag::orderBy('created_at', 'desc')->get();
        return ["columns" => $column, "tags" => $tag];
    }

    public function store(Request $request)
    {
        $articleReqBody = $this->validate(request(), [
            'title' => 'required|string|min:1',
            'column_id' => 'required|integer',
            'tag_ids' => 'required|array',
            'content' => 'required|string',
        ]);
        $articleReqBody['user_id'] = Auth::id();
        $articleReqBody['content'] = $request->get('content');
        $articleReqBody['mainPic'] = $request->get('mainPic');
//        mainPic
        $article = Article::create($articleReqBody);
        $article->tags()->attach($articleReqBody['tag_ids']);
        // 204
        return response('', 204);
    }

    public function uploadPic(Request $request)
    {
        $mainPic = $request->file('mainPic')->store('/public/' . date('Y-m-d') . '/article');
        $mainPic = Storage::url($mainPic);
        return $mainPic;
    }

    public function initEdit(Request $request, $id)
    {
        $res = Article::with('tags')->find($id);
        return $res;
    }
    public function destroy(Article $article)
    {
        $res = $article->delete();
    }
    public function zan(Article $article){
        Auth::user()->upVote($article);
        return response('',204);
    }
    public function unzan(Article $article){
        Auth::user()->cancelVote($article);
        return response('',204);
    }
    public function isZan(Article $article){
        return [
            "is_zan" => $article->isUpVotedBy(Auth::user())
            ];
    }

}

