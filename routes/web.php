<?php
use Illuminate\Http\Request;
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
Route::get('/', function(){
	// TODO here for your custom routes;
	return redirect(env('APP_REDIRECT'));
});
include('pages.php');
Route::get('setup/{config}', 'Core\SettingsController@setup');
Route::get('login', 'Core\AuthController@login');
Route::get('img/{path}', 'Core\ImageController@show')->where('path', '.*');
Route::post('error', function(Request $request) {
    \Mail::to(env('APP_EMAIL','apitoolz@gmail.com'))->send(new App\Mail\ErrorReport($request->all()));
    return redirect('/')->with(['message'=>'Error report has been submited.','status'=>'success']);

});
Route::group(['middleware' => ['web','auth'], 'prefix'=>'admin'], function () {
	Route::get('/', function(){
		return redirect(env('APP_REDIRECT'));
	});
	include('routes.php');
});
Route::group(['middleware'=>['web']],function() {
    
    Route::post('login', 'Core\AuthController@signin');
    Route::get('register', 'Core\AuthController@create');
    Route::post('register', 'Core\AuthController@register');
    Route::get('activation', 'Core\AuthController@activate');
    Route::get('remember', 'Core\AuthController@getRemember');
    Route::post('remember', 'Core\AuthController@postRemember');
    Route::get('reset/{token}', 'Core\AuthController@getReset');
    Route::post('reset/{token}', 'Core\AuthController@postReset');

    Route::group(['middleware'=>['auth']], function() {
    	// Dashboard
    	Route::get('dashboard','Core\DashboardController@index');
    	// User
		Route::group(['prefix'=>'user'], function() {
			Route::get('/', 'Core\UserController@getIndex');
			Route::get('update', 'Core\UserController@getUpdate');
			Route::get('update/{id}', 'Core\UserController@getUpdate');
			Route::get('show/{id}', 'Core\UserController@getShow');
			Route::post('save', 'Core\UserController@postSave');
			Route::post('delete', 'Core\UserController@postDelete');
			Route::get('search', 'Core\UserController@getSearch');
			Route::post('multisearch', 'Core\UserController@postMultisearch');
			Route::post('filter', 'Core\UserController@postFilter');
			Route::get('download', 'Core\UserController@getDownload');
			Route::get('comboselect', 'Core\UserController@getComboselect');
			Route::get('blast', 'Core\UserController@getBlast');
			Route::post('blast', 'Core\UserController@postDoblast');

			Route::get('groups', 'Core\GroupsController@getIndex');
			Route::get('groups/update', 'Core\GroupsController@getUpdate');
			Route::get('groups/update/{id}', 'Core\GroupsController@getUpdate');
			Route::get('groups/show/{id}', 'Core\GroupsController@getShow');
			Route::post('groups/save', 'Core\GroupsController@postSave');
			Route::post('groups/delete', 'Core\GroupsController@postDelete');
			Route::post('groups/filter', 'Core\GroupsController@postFilter');
			Route::get('groups/download', 'Core\GroupsController@getDownload');

			Route::get('logs', 'Core\LogsController@getIndex');
			Route::get('logs/update/{id}', 'Core\LogsController@getUpdate');
			Route::get('logs/show/{id}', 'Core\LogsController@getShow');
			Route::get('logs/save/{id}', 'Core\LogsController@postSave');
			Route::post('logs/delete', 'Core\LogsController@postDelete');
			Route::get('logs/download', 'Core\LogsController@getDownload');
			Route::post('logs/filter', 'Core\LogsController@postFilter');

			Route::get('profile', 'Core\AuthController@getProfile');
            Route::post('profile/{id}', 'Core\AuthController@postProfile');
            Route::post('password/{id}', 'Core\AuthController@postPassword');
            Route::get('logout', 'Core\AuthController@logout');
		});

		Route::group(['middleware'=>['toolz'],'prefix'=>'core'], function(){
			Route::get('api', 'Core\GraphController@guide');
			Route::group(['prefix'=>'model'], function(){
				Route::get('/', 'Core\ModelController@index');
				Route::post('/', 'Core\ModelController@postModel');
				Route::get('{table}/destory', 'Core\ModelController@destory');
				Route::post('destory', 'Core\ModelController@destory');
				Route::get('create', 'Core\ModelController@create');
				Route::get('createfrom', 'Core\ModelController@createFromSQL');
				Route::post('fromsql', 'Core\ModelController@postFromSQL');
				Route::post('export', 'Core\ModelController@getExport');
				Route::post('doexport', 'Core\ModelController@doexport');
				Route::get('import', 'Core\ModelController@getImport');
				Route::post('import', 'Core\ModelController@postImport');
				Route::get('rebuild/{id}', 'Core\ModelController@getRebuild');
				Route::post('rebuild', 'Core\ModelController@postRebuild');
				Route::get('config/{id}', 'Core\ModelController@getConfig');
				Route::get('config/{id}/{view}', 'Core\ModelController@getConfig');
				Route::post('config/{id}/info', 'Core\ModelController@postInfo');
				Route::post('config/{id}/sql', 'Core\ModelController@postSql');
				Route::post('config/{id}/table', 'Core\ModelController@postTable');
				Route::post('config/{id}/conn', 'Core\ModelController@postConn');
				Route::post('config/{id}/form', 'Core\ModelController@postForm');
				Route::post('config/{id}/field', 'Core\ModelController@postFormField');
				Route::post('config/{id}/subform', 'Core\ModelController@postSubForm');
				Route::get('config/{id}/subform/remove', 'Core\ModelController@removeSubForm');
				Route::post('config/{id}/formdesign', 'Core\ModelController@postFormDesign');
				Route::post('config/{id}/relation', 'Core\ModelController@postRelation');
				Route::get('config/{id}/relation/remove', 'Core\ModelController@removeRelation');
				Route::post('config/{id}/permission', 'Core\ModelController@postPermission');
				Route::post('config/{id}/email', 'Core\ModelController@postEmail');
				Route::get('config/{id}/email/remove', 'Core\ModelController@removeEmail');
				Route::post('config/{id}/sms', 'Core\ModelController@postSMS');
				Route::get('combotable', 'Core\ModelController@getCombotable');
				Route::get('combotablefield', 'Core\ModelController@getCombotablefield');
				Route::get('combotable', 'Core\ModelController@getCombotable');
				Route::get('combotablefield', 'Core\ModelController@getCombotablefield');
			});

			Route::group(['prefix'=>'table'], function(){
				Route::get('/', 'Core\DatabaseTableController@index');
				Route::get('/create', 'Core\DatabaseTableController@create');
				Route::get('/{table}/edit', 'Core\DatabaseTableController@create');
				Route::post('/', 'Core\DatabaseTableController@store');
				Route::post('{table}/update', 'Core\DatabaseTableController@update');
				Route::get('{table}/field', 'Core\DatabaseTableController@getField');
				Route::post('{table}/field', 'Core\DatabaseTableController@postField');
				Route::get('{table}/remove', 'Core\DatabaseTableController@dropTable');
				Route::post('delete', 'Core\DatabaseTableController@dropTable');
				Route::get('{table}/{field}/remove', 'Core\DatabaseTableController@removeField');
				Route::get('import', 'Core\DatabaseTableController@getImport');
				Route::post('import', 'Core\DatabaseTableController@postImport');
			});

			Route::group(['prefix'=>'view'], function(){
				Route::get('/', 'Core\DatabaseTableController@getView');
				Route::post('/', 'Core\DatabaseTableController@postView');
				Route::get('{view}/remove', 'Core\DatabaseTableController@dropView');
			});

			Route::group(['prefix'=>'graph'], function(){
				Route::get('{id}/{view}', 'Core\GraphController@graph');
				Route::post('{id}/{view}', 'Core\GraphController@postSettings');
				Route::get('builder/{id}/search', 'Core\GraphController@getSearchBuilder');
				Route::get('token', 'Core\GraphController@getToken');
				Route::post('token', 'Core\GraphController@postToken');
			});

			Route::group(['prefix'=>'settings'], function(){
				Route::get('connection', 'Core\SettingsController@getConnection');
				Route::post('connection', 'Core\SettingsController@postConnection');
				Route::get('general', 'Core\SettingsController@getGeneral');
				Route::post('general', 'Core\SettingsController@postGeneral');
				Route::get('security', 'Core\SettingsController@getSecurity');
				Route::post('security', 'Core\SettingsController@postSecurity');
				Route::get('email', 'Core\SettingsController@getEmail');
				Route::post('email', 'Core\SettingsController@postEmail');
				Route::get('mode/{state}', 'Core\SettingsController@changeMode');
			});

			Route::group(['prefix'=>'menu'], function(){
				Route::get('/', 'Core\MenuController@index');
				Route::post('/', 'Core\MenuController@store');
				Route::post('reorder', 'Core\MenuController@reorder');
				Route::get('{id}', 'Core\MenuController@edit');
				Route::post('{id}', 'Core\MenuController@update');
				Route::get('{id}/delete', 'Core\MenuController@destroy');
			});
			
			Route::group(['prefix'=>'storage'], function(){
				Route::get('/', 'Core\StorageController@index');
				Route::get('jstree', 'Core\StorageController@getFiles');
				Route::get('file/do', 'Core\StorageController@operateFile');
				Route::post('file/upload', 'Core\StorageController@uploadFile');
				Route::get('file', 'Core\StorageController@getFileContent');
				Route::post('file', 'Core\StorageController@postFileContent');
				Route::get('perms', 'Core\StorageController@getPerms');
				Route::post('perms', 'Core\StorageController@postPerms');
				Route::get('terminal', 'Core\StorageController@getTerminal');
				Route::post('terminal/command', 'Core\StorageController@postCommand');
			});

			Route::group(['prefix'=>'oauth'], function(){
				Route::get('/', 'Core\ClientController@index');
				Route::get('create', 'Core\ClientController@create');
				Route::post('/', 'Core\ClientController@store');
				Route::get('/{id}/destroy', 'Core\ClientController@destroy');
				Route::get('/{id}/token', 'Core\ClientController@token');
			});

			Route::group(['prefix'=>'page'], function(){
				Route::get('/','Core\PageController@index');
				Route::get('/template','Core\PageController@template');
				Route::get('/create','Core\PageController@create');
				Route::post('/store','Core\PageController@store');
				Route::get('/{id}/edit','Core\PageController@edit');
				Route::post('/{id}/update','Core\PageController@store');
				Route::get('/{id}/destroy','Core\PageController@destroy');
				Route::post('/export','Core\PageController@getExport');
				Route::post('/doexport','Core\PageController@doexport');
				Route::get('/import','Core\PageController@getImport');
				Route::get('/import-url','Core\PageController@postImport');
				Route::post('/import','Core\PageController@postImport');
				Route::post('destroy','Core\PageController@destroy');
				Route::get('filemanager','Core\PageController@getFiles');
			});
			
		});
    });
});