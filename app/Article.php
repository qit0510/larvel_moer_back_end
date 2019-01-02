<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ty666\LaravelVote\Contracts\CanCountUpVotesModel;
use Ty666\LaravelVote\Traits\CanBeVoted;
use Ty666\LaravelVote\Traits\CanCountUpVotes;

class Article extends Model implements CanCountUpVotesModel
{
    protected $fillable = [ 'title', 'content', 'column_id', 'user_id','mainPic'];

    use CanBeVoted, CanCountUpVotes;

    protected $upVotesCountField = 'up_votes_count';
    //关联用户
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //关联评论
    public function comments()
    {
        return $this->hasMany('App\Comments');
    }
    //关联栏目
    public function column()
    {
        return $this->hasMany('App\Column', 'id','column_id');
    }
    //关联标签
    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }
}
