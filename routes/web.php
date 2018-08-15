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

/*
|--------------------------------------------------------------------------
| 後台功能
|--------------------------------------------------------------------------
 */

// 登入/註冊
Auth::routes();

// 預設首頁
Route::get('/', 'HomeController@index');

// 首頁
Route::get('home', 'HomeController@index')->name('home');

// 玩家下注
Route::post('enter', 'HomeController@enter');

// 莊家開獎
Route::get('pick_winner', 'HomeController@pick_winner');
