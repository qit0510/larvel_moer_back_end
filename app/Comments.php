<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $fillable = [ 'user_id', 'content', 'article_id'];
    //关联用户
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    //关联文章
    public function article()
    {
        return $this->belongsTo(Article::class)->user();
    }
    //关联文章
    public function articleDynamic()
    {
        return $this->belongsTo(Article::class);
    }
}
