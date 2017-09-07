<?php

Route::get('geetest', 'WuFan\Geetest\App\Http\Controllers\GeetestController@get')->name('geetest')->middleware('web');
