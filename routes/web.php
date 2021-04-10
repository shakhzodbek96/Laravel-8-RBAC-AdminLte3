<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Blade (front-end) Routes
|--------------------------------------------------------------------------
|
| Here is we write all routes which are related to web pages
| like UserManagement interfaces, Diagrams and others
|
*/

// Default laravel auth routes
Auth::routes();


// Welcome page
Route::get('/', function () {
    return view('welcome');
});

// Change language session condition
Route::get('/language/{lang}',function ($lang){
    $lang = strtolower($lang);
    if ($lang == 'ru' || $lang == 'uz')
    {
        session([
            'locale' => $lang
        ]);
    }
    return redirect()->back();
});

Route::resource('card','Admin\CardController',['except' => []]);

// Web pages
Route::group(['namespace'=>'Blade','middleware' => 'auth'],function (){

    // there should be graphics, diograms about total conditions
    Route::get('/home', 'HomeController@index')->name('home');

    // Users
    Route::get('/users','UserController@index')->name('userIndex');
    Route::get('/user/add','UserController@add')->name('userAdd');
    Route::post('/user/create','UserController@create')->name('userCreate');
    Route::get('/user/{id}/edit','UserController@edit')->name('userEdit');
    Route::post('/user/update/{id}','UserController@update')->name('userUpdate');
    Route::delete('/user/delete/{id}','UserController@destroy')->name('userDestroy');

    // Permissions
    Route::get('/permissions','PermissionController@index')->name('permissionIndex');
    Route::get('/permission/add','PermissionController@add')->name('permissionAdd');
    Route::post('/permission/create','PermissionController@create')->name('permissionCreate');
    Route::get('/permission/{id}/edit','PermissionController@edit')->name('permissionEdit');
    Route::post('/permission/update/{id}','PermissionController@update')->name('permissionUpdate');
    Route::delete('/permission/delete/{id}','PermissionController@destroy')->name('permissionDestroy');

    // Roles
    Route::get('/roles','RoleController@index')->name('roleIndex');
    Route::get('/role/add','RoleController@add')->name('roleAdd');
    Route::post('/role/create','RoleController@create')->name('roleCreate');
    Route::get('/role/{role_id}/edit','RoleController@edit')->name('roleEdit');
    Route::post('/role/update/{role_id}','RoleController@update')->name('roleUpdate');
    Route::delete('/role/delete/{id}','RoleController@destroy')->name('roleDestroy');
});

/*
|--------------------------------------------------------------------------
| This is the end of Blade (front-end) Routes
|-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\-\
*/
