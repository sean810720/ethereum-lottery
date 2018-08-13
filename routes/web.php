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
| 範例
|--------------------------------------------------------------------------
 */
Route::get('account_balance', 'EthExampleController@account_balance');
Route::get('send_money', 'EthExampleController@send_money');
Route::get('send_contract', 'EthExampleController@send_contract');
Route::get('call_contract', 'EthExampleController@call_contract');

/*
|--------------------------------------------------------------------------
| 系統功能
|--------------------------------------------------------------------------
 */

// 開獎
Route::get('pick_winner', 'LotteryController@pick_winner');

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
