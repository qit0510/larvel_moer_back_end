<?php

namespace App\Http\Controllers;
use \App\ParentColumn;
use Illuminate\Http\Request;

class ParentColumnController extends Controller
{
    public function show()
    {
        $res = ParentColumn::orderBy('created_at','desc')->get();
        return $res;
    }
    public function columnsData(){
        $parent = ParentColumn::with('column')->orderBy('created_at','desc')->get();
        return $parent;
    }
    public function create(Request $request)
    {
//        array:2 [
//        "title" => "于皖虎"
//  "remark" => "阿萨德"
//]
        ParentColumn::create($request->all());
        return response('',204);
    }
}
