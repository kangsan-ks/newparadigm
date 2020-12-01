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

Route::get('/', 'Front@main');

Route::get('/about', 'Front@about');
Route::get('/event01', 'Front@event');
Route::get('/event02', 'Front@event');
Route::get('/event03', 'Front@event');
Route::get('/event04', 'Front@event');
Route::get('/event05', 'Front@event');
Route::get('/archive01', 'Front@archive01');
Route::get('/archive01_view', 'Front@archive01_view');
Route::get('/connect', 'Front@connect');
Route::post('/connect_action', 'Front@connect_action');

Route::get('/as_admin/login', 'Back@as_login');
Route::post('/as_admin/login_action', 'Back@as_login_action');
Route::get('/as_admin/logout', 'Back@as_logout');

Route::get('/as_admin/priority_change', 'Back@priority_change');

Route::get('/as_admin/message', 'Back@as_board_list');
Route::get('/as_admin/message/write_board_form', 'Back@write_board_form');
Route::post('/as_admin/message/write_board_action', 'Back@write_board_action');
Route::get('/as_admin/message/write_board_form/modify', 'Back@write_board_form');

Route::get('/as_admin/main_set', 'Back@main_set');
Route::post('/as_admin/change_main_set', 'Back@change_main_set');

Route::get('/as_admin/slide/list', 'Back@list');
Route::get('/as_admin/popup/list', 'Back@list');
Route::get('/as_admin/connect/list', 'Back@list');
Route::get('/as_admin/about/list', 'Back@list');
Route::get('/as_admin/gallery/list', 'Back@list');
Route::get('/as_admin/member/list', 'Back@list');

Route::get('/as_admin/slide/write', 'Back@write');
Route::get('/as_admin/popup/write', 'Back@write');
Route::get('/as_admin/connect/write', 'Back@write');
Route::get('/as_admin/about/write', 'Back@write');
Route::get('/as_admin/gallery/write', 'Back@write');
Route::get('/as_admin/member/write', 'Back@write');

Route::get('/as_admin/slide/modify', 'Back@write');
Route::get('/as_admin/popup/modify', 'Back@write');
Route::get('/as_admin/connect/modify', 'Back@write');
Route::get('/as_admin/about/modify', 'Back@write');
Route::get('/as_admin/gallery/modify', 'Back@write');
Route::get('/as_admin/member/modify', 'Back@write');

Route::post('/as_admin/slide/write_action', 'Back@write_action');
Route::post('/as_admin/popup/write_action', 'Back@write_action');
Route::post('/as_admin/connect/write_action', 'Back@write_action');
Route::post('/as_admin/gallery/write_action', 'Back@write_action');
Route::post('/as_admin/member/write_action', 'Back@write_action');

Route::post('/as_admin/slide/write_action', 'Back@write_action');
Route::post('/as_admin/popup/write_action', 'Back@write_action');
Route::post('/as_admin/connect/write_action', 'Back@write_action');
Route::post('/as_admin/about/write_action', 'Back@write_action');
Route::post('/as_admin/gallery/write_action', 'Back@write_action');
Route::post('/as_admin/member/write_action', 'Back@write_action');

Route::post('/as_admin/slide/control', 'Back@delete_action');
Route::post('/as_admin/popup/control', 'Back@delete_action');
Route::post('/as_admin/connect/control', 'Back@delete_action');
Route::post('/as_admin/about/control', 'Back@delete_action');
Route::post('/as_admin/gallery/control', 'Back@delete_action');
Route::post('/as_admin/member/control', 'Back@delete_action');