<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});
Route::post('search','MovieController@search');

Route::any('play','MovieController@play');

Route::any('detail','MovieController@detail');
//Route::get('detail', function () {
//    return view('album_detail');
//});

Route::get('feedback',function(){
   return view('feedback');
});
Route::get('about',function(){
    return view('about');
});
Route::get('chatroom',function(){
    $uid=Session('uid');
    if(!$uid){
        echo "请先登录";
    }else{
        return view('chatroom');
    }

});


Route::post('feedback','MovieController@feedback');

Route::get('captcha',"UserController@captcha");

Route::get('longconnect',"ServerController@server_start");

Route::post('register',"UserController@register");

Route::post('login',"UserController@login");

Route::get('hot',"MovieController@hot");

Route::get('lastWatch',"UserController@lastWatch");

Route::get('mySubscribe',"UserController@mySubscribe");

Route::get('getMovie',"GetMovieController@movieGet");

Route::get('sexy',"MovieController@sexy");

Route::post('addMovie',"MovieController@addMovie");
Route::post('subscribe',"UserController@subscribe");
//Route::get('hot',function(){
//    return view('hot');
//});
