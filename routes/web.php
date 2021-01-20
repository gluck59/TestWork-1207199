<?php

Route::get('/','ListController@index');
Route::post('create','ListController@create');
Route::post('delete','ListController@delete');
Route::post('update','ListController@update');



