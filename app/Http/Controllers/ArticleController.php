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
    //获取所有文章列表
    public function show()
    {
        $res = Article::with('tags', 'column')->orderBy('created_at', 'desc')->get();
        return $res;
    }
    //个人文章列表
    public function getArticle(){
        $res = Article::where('user_id',Auth::id())->with('comments','tags')->orderBy('created_at', 'desc')->get();
        return $res;
    }

    //热门文章
    public function hot(){
        $res = Article::orderBy('created_at', 'desc')->get();
        return $res;
    }
    //文章列表
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
    //taglist
    public function tagArtList(){
        $article = Article::with('user','tags')->orderBy('created_at', 'desc')->get();
        dd($article);
    }
    public function nextPage(){
    }
    //文章详情
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
    //文章保存
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
    //上传图片
    public function uploadPic(Request $request)
    {
        $mainPic = $request->file('mainPic')->store('/public/' . date('Y-m-d') . '/article');
        $mainPic = Storage::url($mainPic);
        return $mainPic;
    }
    //初始化编辑
    public function initEdit(Request $request, $id)
    {
        $res = Article::with('tags')->find($id);
        return $res;
    }
//    删除
    public function destroy(Article $article)
    {
        $res = $article->delete();
    }
    //赞
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
    //我点赞的人
    public function getZanUser(){
        $res = Article::orderBy('created_at', 'desc')->get();
        $res = Auth::id();
    }
}

