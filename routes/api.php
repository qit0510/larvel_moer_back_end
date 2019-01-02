<?php

//auth
Route::post('/register', 'RegisterController@register');
Route::post('/loginUser', 'LoginController@login');
//Route::post('/loginEmail', 'LoginController@loginEmail');
Route::get('/logout', 'LoginController@logout');

Route::get('/article/artlist', 'ArticleController@artList');
Route::get('/hotArticle', 'ArticleController@hot');

Route::get('/life/web_front', 'ArticleController@columnArtList');
Route::get('/life/Sa', 'ArticleController@columnArtList');
Route::get('/skill/web_back', 'ArticleController@columnArtList');
Route::get('/skill/test', 'ArticleController@columnArtList');

Route::get('tag/c++', 'TagController@tagArtList');
Route::get('tag/css', 'TagController@tagArtList');
Route::get('tag/java', 'TagController@tagArtList');
Route::get('/tag', 'TagController@show');


Route::get('/article/details/{id}','ArticleController@details');

Route::get('/comment/{article}', 'CommentsController@show');
Route::get('/parent', 'ParentColumnController@columnsData');

Route::get('/user/check','UserController@check');
Route::group(['middleware' => 'auth'], function () {
//artisan
    Route::get('/article', 'ArticleController@show');
    Route::get('/article/create', 'ArticleController@getArticleData');
    Route::post('/article/create', 'ArticleController@store');
    Route::post('/article/uploadPic', 'ArticleController@uploadPic');
    Route::get('/initEdit/{article}', 'ArticleController@initEdit');
    Route::delete('/article/{article}/delete', 'ArticleController@destroy');
    Route::post('/article/{article}/zan', 'ArticleController@zan');
    Route::post('/article/{article}/unzan', 'ArticleController@unzan');
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
});
