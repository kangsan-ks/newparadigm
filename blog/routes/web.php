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
Route::get('/gallery', 'Front@gallery');
Route::get('/gallery_view', 'Front@gallery_view');
Route::get('/notice', 'Front@notice');
Route::get('/notice_view', 'Front@notice_view');
Route::get('/about_list', 'Front@about_list');
Route::get('/about_view', 'Front@about_view');

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
Route::get('/as_admin/notice/list', 'Back@list');
Route::get('/as_admin/about/list', 'Back@list');
Route::get('/as_admin/gallery/list', 'Back@list');
Route::get('/as_admin/member/list', 'Back@list');

Route::get('/as_admin/slide/write', 'Back@write');
Route::get('/as_admin/popup/write', 'Back@write');
Route::get('/as_admin/notice/write', 'Back@write');
Route::get('/as_admin/about/write', 'Back@write');
Route::get('/as_admin/gallery/write', 'Back@write');
Route::get('/as_admin/member/write', 'Back@write');

Route::get('/as_admin/slide/modify', 'Back@write');
Route::get('/as_admin/popup/modify', 'Back@write');
Route::get('/as_admin/notice/modify', 'Back@write');
Route::get('/as_admin/about/modify', 'Back@write');
Route::get('/as_admin/gallery/modify', 'Back@write');
Route::get('/as_admin/member/modify', 'Back@write');

Route::post('/as_admin/slide/write_action', 'Back@write_action');
Route::post('/as_admin/popup/write_action', 'Back@write_action');
Route::post('/as_admin/notice/write_action', 'Back@write_action');
Route::post('/as_admin/gallery/write_action', 'Back@write_action');
Route::post('/as_admin/member/write_action', 'Back@write_action');

Route::post('/as_admin/slide/write_action', 'Back@write_action');
Route::post('/as_admin/popup/write_action', 'Back@write_action');
Route::post('/as_admin/notice/write_action', 'Back@write_action');
Route::post('/as_admin/about/write_action', 'Back@write_action');
Route::post('/as_admin/gallery/write_action', 'Back@write_action');
Route::post('/as_admin/member/write_action', 'Back@write_action');

Route::post('/as_admin/slide/control', 'Back@delete_action');
Route::post('/as_admin/popup/control', 'Back@delete_action');
Route::post('/as_admin/notice/control', 'Back@delete_action');
Route::post('/as_admin/about/control', 'Back@delete_action');
Route::post('/as_admin/gallery/control', 'Back@delete_action');
Route::post('/as_admin/member/control', 'Back@delete_action');