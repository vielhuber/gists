<?php
// how to exclude: add doNotCacheResponse Middleware to routes/groups
Route::group(['middleware' => ['auth','doNotCacheResponse']], function() {
	Route::get('dashboard', ["as" => "getDashboard", "uses" => "DashboardController@getDashboard"]);
	...