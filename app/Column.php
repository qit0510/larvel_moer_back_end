<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    protected $guarded = [];
    //关联父栏目
    public function parentColumn()
    {
        return $this->belongsTo(ParentColumn::class);
    }
    //关联文章
    public function Article()
    {
        return $this->belongsTo('App\Article');
    }
}
