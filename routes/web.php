<?php

use Illuminate\Support\Facades\Route;

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

$backend = '/admin';

Route::get('/', function () {
    return redirect()->route("login_page");
});


Route::group(['prefix' =>  '/auth'], function () {
    Route::get('/', 'AuthenticationController@actionHomeLogin')->name("login_page");
    Route::get('/rmuti', 'AuthenticationController@actionHomeRMUTILogin')->name("login_rmuti_page");
    Route::get('/login_rmuti', 'AuthenticationController@actionLoginRmuti')->name("login_rmuti_data");
    Route::post('/login', "AuthenticationController@actionLogin")->name('login_data');
    Route::get('/logout', "AuthenticationController@actionLogout")->name('logout_data');
});


Route::group(['prefix' => '/topic', 'middleware' => ['guest'] ], function () {

    /*
        สร้างข้อมูลหัวข้อคำถาม
    */
    Route::get('/', "TopicController@actionIndex")->name('topic_index_page'); // เรียกรายการหัวข้อที่ตั้งมีอะไรบ้าง
    Route::get('/create', "TopicController@actionCreate")->name('topic_create_page'); // เข้าหน้าต่างสร้างคำถาม


    Route::get('/{id}', "TopicController@actionView")->name('topic_view_page'); // ดูคำถาม + มีคำตอบอะไรบ้าง
    Route::get('/track/{id}', "TopicController@actionTrack")->name('topic_track_page');

    Route::post('/create', "TopicController@actionCreate")->name('topic_create_data');
    Route::post('/tracking', "TopicController@actionTracking")->name('topic_tracking_data');
    Route::get('/delete/{id}', "TopicController@actionDelete")->name('topic_delete_data');
});


Route::group(['prefix' => '/relations', 'middleware' => ['guest'] ], function () {
    Route::get('/', function () {
        return redirect('https://rmutiresearch.blogspot.com/');
    })->name('relations_index_page');
});

Route::group(['prefix' => '/answer', 'middleware' => ['guest'] ], function () {

    /*
        สร้างข้อมูลการตอบคำถามในหัวข้อ ( answer )
    */

    Route::post('/create', "AnswerController@actionCreate")->name('answer_create_data');
    Route::get('/delete/{id}', "AnswerController@actionDelete")->name('answer_delete_data');
});

Route::group(['prefix' =>  $backend . '/dashboard', 'middleware' => ['guest'] ], function () {

    Route::get('/', "DashboardController@actionIndex")->name('dashboard_index_page');

});


Route::group(['prefix' =>  $backend . '/question', 'middleware' => ['guest' , 'admin'] ], function () {

    /*
        ดูข้อมูลหัวข้อคำถาม (admin)
    */
    Route::get('/', "QuestionController@actionIndex")->name('question_index_page'); // ดูคำถามทั้งหมดว่ามีรายการอะไรบ้างพร้อมสถานะว่ามีการตอบแล้วรึยัง
    Route::get('/{id}', "TopicController@actionView")->name('question_view_page'); // ดูคำถาม + มีคำตอบอะไรบ้าง
    Route::get('/delete/{id}', "TopicController@actionDelete")->name('question_delete_data');

});

Route::group(['prefix' =>  $backend . '/account', 'middleware' => ['guest' , 'admin'] ], function () {

    /*
        ดูข้อมูลหัวข้อคำถาม (admin)
    */

    Route::get('/', "AccountController@actionIndex")->name('account_index_page'); // ดูข้อมูลผู้ใช้งานทั้งหมด ว่ามีการตั้งคำถามกี่คำถาม

});

Route::group(['prefix' =>  $backend . '/graph', 'middleware' => ['guest' , 'admin'] ], function () {

    /*
        graph
    */
    
    Route::get('/graph', "GraphController@actionIndex")->name('graph_index_page'); // ดูว่ามาจากคณะอะไรบ้าง , เปเปอร์ที่ส่งมามีประเภทอะไรบ้าง

});


Route::group(['prefix' =>  $backend . '/tracking', 'middleware' => ['guest' , 'admin'] ], function () {

    /*
        tracking
    */
    
    Route::get('/tracking', "TrackingController@actionIndex")->name('tracking_index_page'); 
    Route::post('/create', "TrackingController@actionCreate")->name('tracking_create_data'); 

    Route::get('/update/{id}', "TrackingController@actionView")->name('tracking_view_page'); 
    Route::post('/update', "TrackingController@actionUpdate")->name('tracking_update_data'); 
    Route::get('/delete/{id}', "TrackingController@actionDelete")->name('tracking_delete_data'); 

});