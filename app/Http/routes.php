<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


use App\Post;
use Illuminate\Foundation\Http\Middleware\Authorize;

Route::group(['middleware'=>['web']], function(){

    Route::get('/', function () {
        return view('welcome');
    });

    Route::auth();

    Route::get('/home', 'HomeController@index');

});


Route::group(['middleware' => 'admin','namespace' => 'Admin','prefix' => 'admin' ], function () {

    Route::bind('post',function($post){
        $post = new Post();
        return $post;
    });

    Route::get('dashboard',function(){
        return '<h1>Welcome to the admin panel</h1>';
    });

    Route::get('posts',function(){
        return 'List of posts';
    })->middleware(Authorize::class.':view,'.Post::class);

    Route::get('posts/create',function(){
        return 'Form create posts';
    });

    Route::post('posts',function(){
        return 'Store post in the DB';
    });

    Route::get('posts/{post}/edit',function($post){
        return 'Edit post Form '.$post;
    })->middleware(Authorize::class.':edit,post');

    Route::put('posts/{post}',function(){
        return 'Update post Form in the DB';
    });

    Route::delete('posts/{post}',function(){
        return 'Delete post Form in the DB';
    });


});