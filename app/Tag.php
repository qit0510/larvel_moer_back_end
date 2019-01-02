<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tag extends Model
{
    protected $guarded = ['id'];

    public function article()
    {
        return $this->belongsToMany('App\Article');
    }
}
