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
    return view('user.index');
});

// use Illuminate\Routing\Route;

// Customer Route
Route::group(['middleware' => ['customer']], function () {
    Route::post('/change', 'AlbumController@change');
    // Route::get('/', 'AlbumController@index');
    Route::get('/customer', 'AlbumController@upload');
    Route::get('/hapus/{album}', 'AlbumController@destroy');
    Route::get('/print', 'AlbumController@print');
    // Route::get('/download', 'AlbumController@download');
    Route::get('/layouts', 'AlbumController@layouts');
    // Route::get('/preview', 'AlbumController@preview');
    Route::get('/layouts/{userLayouts}', 'AlbumController@destroyLayout');
    Route::post('/customer', 'AlbumController@store');
    Route::post('/bgUpload', 'AlbumController@bgUpload');
});

// Admin Route
Route::group(['middleware' => ['admin']], function () {
    Route::get('/admin', 'AdminController@index');
    Route::get('/admin/task', 'AdminController@task');
    Route::get('/preview', 'AdminController@preview');
    Route::get('/download', 'AdminController@download');
    Route::delete('/hapus', 'AdminController@destroy');
    Route::post('/changeImageAdmin', 'AdminController@changeImage');
    Route::post('/changePasswordAdmin', 'AdminController@changePassword');
    Route::post('/updateStatus', 'AdminController@updateStatus');
});

// Super Admin Route
Route::group(['middleware' => ['superUser']], function () {
    Route::get('/superUser', 'SuperUserController@index');
    Route::get('/superUser/admin', 'SuperUserController@admin');
    Route::get('/superUser/customer', 'SuperUserController@customer');
    Route::get('/superUser/tasks', 'SuperUserController@tasks');
    Route::get('/superUser/cari', 'SuperUserController@cariAdmin');
    Route::get('/superUser/cari/customer', 'SuperUserController@cariCustomer');
    Route::delete('/hapusAdmin', 'SuperUserController@destroyAdmin');
    Route::delete('/hapusCustomer', 'SuperUserController@destroyCustomer');
    Route::delete('/hapusTask', 'SuperUserController@destroyTask');

    Route::put('/ubahAdmin', 'SuperUserController@updateAdmin');
    Route::put('/ubahCustomer', 'SuperUserController@updateCustomer');
    Route::post('/changeImage', 'SuperUserController@changeImage');
    Route::post('/changePassword', 'SuperUserController@changePassword');
    Route::post('/changeName', 'SuperUserController@changeName');
    Route::post('/superUser/admin', 'SuperUserController@createAdmin');
    Route::post('/superUser/customer', 'SuperUserController@createCustomer');
    Route::post('/superUser/tasks', 'SuperUserController@createTasks');
});

Route::get('/logout', 'Auth\LoginController@logout');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
