<?php

namespace App\Http\Controllers;

use App\Column;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
class ColumnController extends Controller
{
    public function show()
    {
        $res = Column::With('parentColumn')->orderBy('created_at', 'desc')->get();
        return $res;
    }
    public function store(Request $request){
        $res = $this->validate(request(),[
            'title' => 'required|string',
            'remark' => 'required|string',
            'parentId' => 'required|integer'
        ]);
        Column::create($res);
    }
    public function initEdit(Request $request, $id)
    {
        $res =Column::with('tags')->find($id);
//        return $res;
    }
    public function destroy(Column $column)
    {
        $res = $column->delete();
        if ($res) {
            return \response('', Response::HTTP_NO_CONTENT);
        } else {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR, '删除失败');
        }
    }
}
