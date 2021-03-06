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

//use App\Services\Twitter;
//
//Route::get('/', function (Twitter $twitter) {
//    dd($twitter);
//    return view('welcome');
//});

//    Route::get('/', function () {
//    dd(auth()->id());
//    return view('welcome');
//});

    use App\Notifications\SubscriptionRenewalFailed;
    use Illuminate\Http\Request;

Route::get('/','PagesController@home');
Route::get('/about', 'PagesController@about');
Route::get('/contact', 'PagesController@contact');

/*
 * GET  /projects {index}
 * GET /projects/create {create}
 * GET /projects/1 {show}
 * POST /projects {store}
 * GET /projects/1/edit {edit}
 * PATCH /projects/1 {update}
 * DELETE /projects/1 {destroy}
 */



//
//Route::get('/projects','ProjectsController@index');
//Route::get('/projects/create','ProjectsController@create');
//Route::get('/projects/{project}','ProjectsController@show');
//Route::post('/projects','ProjectsController@store');
//Route::get('/projects/{project}/edit','ProjectsController@edit');
//Route::patch('/projects/{project}','ProjectsController@update');
//Route::delete('/projects/{project}','ProjectsController@destroy');

Route::resource('projects','ProjectsController');

Route::PATCH('tasks/{task}','ProjectTasksController@update');
Route::POST('/projects/{project}/tasks','ProjectTasksController@store');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/notification', function() {
    $user = App\User::first();
    $user->notify(new SubscriptionRenewalFailed);
    return 'Done';
});

//Route::get('/test',function(){
////   session(['name'=>'Moji']);
//    return session('name');
//    return view('layout');
//});
Route::get('/test-two',function (Request $request){
//    $request->session()->put('foobar','baz');
      return $request->session()->get('foobar');
});
