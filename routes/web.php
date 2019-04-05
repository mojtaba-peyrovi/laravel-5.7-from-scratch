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
    $tasks = [
        'go to store',
        'buy stuff',
        'come back home'
    ];
//    return view('welcome', [
//        'tasks' => $tasks,
//        'foo' => request('title')
//    ]);
    return view('welcome')->withTasks($tasks)->withFoo(request('title'));
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/about', function () {
    return view('about');
});




