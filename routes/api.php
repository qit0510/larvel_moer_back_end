<?php

//auth
Route::post('/register', 'RegisterController@register');
Route::post('/loginUser', 'LoginController@login');
//Route::post('/loginEmail', 'LoginController@loginEmail');
Route::get('/logout', 'LoginController@logout');

Route::get('/article/artlist', 'ArticleController@artList');
Route::get('/hotArticle', 'ArticleController@hot');

Route::get('/recordsharing/mood', 'ArticleController@columnArtList');
Route::get('/recordsharing/diary', 'ArticleController@columnArtList');
Route::get('/recordsharing/live', 'ArticleController@columnArtList');
Route::get('/Skillsanalysis/algorithmanalysis', 'ArticleController@columnArtList');

Route::get('tag/c++', 'TagController@tagArtList');
Route::get('tag/css', 'TagController@tagArtList');
Route::get('tag/java', 'TagController@tagArtList');
Route::get('/tag', 'TagController@show');


Route::get('/article/details/{id}','ArticleController@details'); //文章详情

Route::get('/comment/{article}', 'CommentsController@show');
Route::get('/parent', 'ParentColumnController@columnsData');

Route::get('/user/check','UserController@check');
Route::group(['middleware' => 'auth'], function () {
//artisan
    Route::get('/article', 'ArticleController@show'); //获取所有文章列表
    Route::get('/getArticle', 'ArticleController@getArticle'); //获取个人文章列表
    Route::get('/article/create', 'ArticleController@getArticleData'); // 创建文章初始化column和tag
    Route::post('/article/create', 'ArticleController@store'); //创建文章
    Route::post('/article/uploadPic', 'ArticleController@uploadPic'); //上传图片
    Route::get('/initEdit/{article}', 'ArticleController@initEdit'); //初始化编辑
    Route::delete('/article/{article}/delete', 'ArticleController@destroy'); //删除
    Route::post('/article/{article}/zan', 'ArticleController@zan'); //点赞
    Route::post('/article/{article}/unzan', 'ArticleController@unzan'); //取消赞
//comment
    Route::post('/comment/{article}', 'CommentsController@store');
    Route::get('/dynamic','CommentsController@dynamic');

//column
    Route::get('/column', 'ColumnController@show');
    Route::get('/columnParent', 'ParentColumnController@show');
    Route::post('/columnParentCreate', 'ParentColumnController@create');
    Route::get('/initColumnEdit/{column}', 'ColumnController@initEdit');
    Route::post('/column/create', 'ColumnController@store');
    Route::post('/column/{column}/editor', 'ColumnController@index');
    Route::delete('/column/{column}/delete', 'ColumnController@destroy');
//tag
    Route::put('/tag/create', 'TagController@create');
    Route::post('/tag/{tag}/editor', 'TagController@update');
    Route::delete('/tag/{tag}/delete', 'TagController@destroy');
    Route::get('/validateUser','UserController@validateUser');

//    个人设置
    Route::get('getAuth', 'UserController@getAuth');
    Route::post('changeAuth','UserController@changeAuth');
    Route::post('/user/uploadAvatar', 'UserController@uploadAvatar');
//    Route::get('/user/follow/{user}','UserController@follow');
});
