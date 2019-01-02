<?php

namespace App\Http\Controllers;

use App\Article;
use App\Tag;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TagController extends Controller
{
    /**
     * 获取 tag.
     *
     * @return tag 详细信息数组
     */
    public function show()
    {
        $res = tag::orderBy('created_at', 'desc')->get();
        return $res;
    }
    public function tagArtList(Request $request){
        $ele = array_slice(explode('/',$request->path()),-1,1);
        $res = tag::where('remark',$ele[0])->with('article', 'article.user','article.comments')->get();
        return $res;
    }

    public function create()
    {
        $tag = new Tag();
        $tag->title ='Tag Name';
        $tag->remark = 'Tag remark';
        $tag->save();
    }
    public function update(Request $request, Tag $tag)
    {
        $this->validate(request(),[
            'id'=>'required|integer',
            'title'=>'required|string|min:1',
            'remark'=>'required|string',
        ]);
        $tag->title = $request->get('title');
        $tag->remark = $request->get('remark');
        $tag->save();
    }

    public function destroy(Tag $tag)
    {
        $res = $tag->delete();
        if ($res) {
            return \response('', Response::HTTP_NO_CONTENT);
        } else {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR, '删除失败');
        }
    }
}
