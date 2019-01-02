<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParentColumn extends Model
{
    protected $fillable = [
        'title', 'remark'
    ];
    //关联子栏目
    public function column()
    {
        return $this->hasMany('App\Column','parentId','id');
    }
}
