<?php

	/* Customer routes group */
	Route::group(['prefix'=>'customer'], function() {
		Route::get('/', 'CustomerController@getIndex');
		Route::get('update', 'CustomerController@getUpdate');
		Route::get('update/{id}', 'CustomerController@getUpdate');
		Route::get('show/{id}', 'CustomerController@getShow');
		Route::post('save', 'CustomerController@postSave');
		Route::post('delete/{id}', 'CustomerController@postDelete');
		Route::get('savepublic', 'CustomerController@postSavepublic');
		Route::get('download', 'CustomerController@getDownload');
		Route::get('search', 'CustomerController@getSearch');
		Route::get('comboselect', 'CustomerController@getComboselect');
		Route::get('removefiles', 'CustomerController@getComboselect');
		Route::post('filter', 'CustomerController@postFilter');
		Route::get('lookup/{master_detail}', 'CustomerController@getLookup');
	});

	/* Test routes group */
	Route::group(['prefix'=>'test'], function() {
		Route::get('/', 'TestController@getIndex');
		Route::get('update', 'TestController@getUpdate');
		Route::get('update/{id}', 'TestController@getUpdate');
		Route::get('show/{id}', 'TestController@getShow');
		Route::post('save', 'TestController@postSave');
		Route::post('delete/{id}', 'TestController@postDelete');
		Route::get('savepublic', 'TestController@postSavepublic');
		Route::get('download', 'TestController@getDownload');
		Route::get('search', 'TestController@getSearch');
		Route::get('comboselect', 'TestController@getComboselect');
		Route::get('removefiles', 'TestController@getComboselect');
		Route::post('filter', 'TestController@postFilter');
		Route::get('lookup/{master_detail}', 'TestController@getLookup');
	});

?>