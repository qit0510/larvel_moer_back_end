<?php

namespace App\Http\Controllers;

use App\Article;
use App\Column;
use App\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{

    public function store(Request $request,Article $article)
    {
        $comment = $this->validate(request(), [
            'content' => 'required|string',
        ]);
        $comment['user_id'] = Auth::id();
        $comment['article_id'] = $article->id;
        return Comments::create($comment);
    }
    public function dynamic(){
        $res = Article::where('user_id',Auth::id())->with('comments','user')->orderBy('created_at', 'desc')->get();
        return $res;
    }
    public function show($id)
    {
        $res = Comments::where('article_id',$id)->with('user')->get();
        return $res;
    }

}
