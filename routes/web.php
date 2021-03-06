<?php

use App\Kategori;

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
    return view('welcome');
});

Auth::routes();

Route::get('/register', function(){
    return redirect('/');
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/post/{post}', 'PostController@show')->name('post.show');

Route::get('/kompetisi/{kategori}', 'KompetisiController@getPagesByCategory')->name('kompetisi.index');
Route::get('/kompetisi/{kategori}/daftar', 'KompetisiController@getPageDaftar')->name('kompetisi.daftar');
Route::post('/kompetisi/{kategori}/store', 'Admin/TimController@store')->name('kompetisi.store');
Route::get('/kompetisi/{kategori}/peserta', 'KompetisiController@getPagePeserta')->name('kompetisi.peserta');

Route::get('/kompetisi/{kategori}/submit', 'SubmissionController@getPageSubmit')->name('kompetisi.submit.index');
Route::get('/kompetisi/{kategori}/submit/store', 'SubmissionController@submitFile')->name('kompetisi.submit.store');

Route::get('/test', function (){

    $data = new stdClass();
    $data->kategori = 'Pengembangan Perangkat Lunak';
    $data->submission_code = 'loremipsumdolorsitamet';
    $data->sender = ucfirst(Auth::user()->name);
    $data->receiver = 'Miqdad Yanuar';

    \Illuminate\Support\Facades\Mail::to('miqdad.farcha@gmail.com')->send(new \App\Mail\SubmissionMail($data));
});

Route::group(['namespace' => 'Admin', 'as' => 'admin.', 'prefix' => 'admin', 'middleware' =>['auth']], function(){

    Route::get('/', function (){
        return "THIS IS INDEX";
    })->name('index');

    Route::group(['middleware' => ['ormawa']], function (){
        /* TIM */

        // READ
        Route::get('tim/{kategori}', 'TimController@index')->name('tim.index');
        Route::get('tim/{kategori}/{tim}', 'TimController@show')->name('tim.show');
        // CREATE
        Route::get('tim/{kategori}/create', 'TimController@create')->name('tim.create');
        Route::post('tim/{kategori}/store', 'TimController@store')->name('tim.store');
        // EDIT
        Route::get('tim/{kategori}/{tim}/edit', 'TimController@edit')->name('tim.edit');
        Route::post('tim/{kategori}/update', 'TimController@update')->name('tim.update');
        // DELETE
        Route::post('tim/{kategori}/{tim}/destroy', 'TimController@destroy')->name('tim.delete');
    });


    /* POST */

    // READ
    Route::get('post/', 'PostController@index')->name('post.index');
    // CREATE
    Route::get('post/create', 'PostController@create')->name('post.create');
    Route::post('post/store', 'PostController@store')->name('post.store');
    // EDIT
    Route::get('post/{post}/edit', 'PostController@edit')->name('post.edit');
    Route::post('post/update', 'PostController@update')->name('post.update');
    // DELETE
    Route::post('post/destroy', 'PostController@destroy')->name('post.destroy');

});
