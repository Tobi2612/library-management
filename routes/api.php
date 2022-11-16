<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Auth
Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', 'AuthController@login');

    Route::post('/register', 'AuthController@register');
});


//Users
Route::group(['prefix' => 'users', 'middleware' => ['jwt-auth']], function () {
    Route::get('/', 'UserController@index')->middleware('role:admin');
    Route::get('/{user_id}', 'UserController@show');
    Route::post('/admin/create', 'UserController@AdminCreateUser')->middleware('role:admin');
    Route::put('/update', 'UserController@update');
    Route::put('/update-role', 'UserController@updateRole')->middleware('role:admin');
    Route::put('/update-status', 'UserController@updateUserStatus')->middleware('role:admin');
    Route::delete('/{id}', 'UserController@destroy')->middleware('role:admin');
});


//lending
Route::group(['prefix' => 'lending', 'middleware' => ['jwt-auth']], function () {
    Route::post('/borrow', 'LendingController@borrowBook');

    Route::post('/return', 'LendingController@returnBook');

    Route::get('/view/borrowed', 'LendingController@viewBorrowed')->middleware('role:owner,admin');

    Route::get('/view/returned', 'LendingController@viewReturned')->middleware('role:owner,admin');

    Route::get('/view-all', 'LendingController@getAllLendings')->middleware('role:admin');
    Route::get('/view', 'LendingController@getLending')->middleware('role:admin');
    Route::put('/update', 'LendingController@updateLending')->middleware('role:admin');
    Route::delete('/delete', 'LendingController@deleteLending')->middleware('role:admin');
});


//plan subcription
Route::group(['prefix' => 'plans', 'middleware' => ['jwt-auth']], function () {
    Route::post('/subcribe', 'PlanSubscriptionController@subscribe')->middleware('role:owner,admin');
    Route::get('/view/subscriptions', 'PlanSubscriptionController@viewSubscriptions')->middleware('role:owner,admin');


    Route::post('/create', 'PlanController@create')->middleware('role:admin');
    Route::get('/view-all', 'PlanController@getAllPlans');
    Route::get('/view', 'PlanController@getPlan');
    Route::put('/update', 'PlanController@updatePlan')->middleware('role:admin');
    Route::put('/update-status', 'PlanController@updatePlanStatus')->middleware('role:admin');
    Route::delete('/delete', 'PlanController@deletePlan')->middleware('role:admin');



    Route::group(['prefix' => 'books'], function () {
        Route::post('/subscribe', 'BookPlanController@subscribe')->middleware('role:admin');
        Route::put('/update-status', 'BookPlanController@updateStatus')->middleware('role:admin');
        Route::get('/view', 'BookPlanController@view');
    });
});


//access level subcription
Route::group(['prefix' => 'access', 'middleware' => ['jwt-auth']], function () {

    Route::post('/create', 'AccessLevelController@create')->middleware('role:admin');
    Route::get('/view-all', 'AccessLevelController@getAllAccessLevels');
    Route::get('/view', 'AccessLevelController@getAccessLevel');
    Route::put('/update', 'AccessLevelController@updateAccessLevel')->middleware('role:admin');
    Route::put('/update-status', 'AccessLevelController@updateAccessLevelStatus')->middleware('role:admin');
    Route::delete('/delete', 'AccessLevelController@deleteAccessLevel')->middleware('role:admin');

    Route::group(['prefix' => 'books'], function () {
        Route::post('/subscribe', 'BookAccessLevelController@subscribe')->middleware('role:admin');
        Route::put('/update-status', 'BookAccessLevelController@updateStatus')->middleware('role:admin');
        Route::get('/view', 'BookAccessLevelController@view');
    });
});


//books
Route::group(['prefix' => 'book', 'middleware' => ['jwt-auth']], function () {

    Route::post('/create', 'BookController@create')->middleware('role:admin');
    Route::get('/view-all', 'BookController@getAllBooks');
    Route::get('/view', 'BookController@getBook');
    Route::put('/update', 'BookController@updateBook')->middleware('role:admin');
    Route::put('/update-status', 'BookController@updateBookStatus')->middleware('role:admin');
    Route::delete('/delete', 'BookController@deleteBook')->middleware('role:admin');
});




//author subcription
Route::group(['prefix' => 'author', 'middleware' => ['jwt-auth']], function () {

    Route::post('/create', 'AuthorController@create')->middleware('role:admin');
    Route::get('/view-all', 'AuthorController@getAllAuthors');
    Route::get('/view', 'AuthorController@getAuthor');
    Route::put('/update', 'AuthorController@updateAuthor')->middleware('role:admin');
    Route::delete('/delete', 'AccessLevelController@deleteAuthor')->middleware('role:admin');

    Route::group(['prefix' => 'book'], function () {
        Route::get('/view', 'AuthorController@getBook');
        Route::put('/update', 'AuthorController@updateBook');
        Route::put('/update-status', 'AuthorController@updateBookStatus');
        Route::delete('/delete', 'AccessLevelController@deleteBook');
    });
});
