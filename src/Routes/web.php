<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::prefix('/w-admin')->middleware('auth')->group( function () {
    Route::resource('pages' , 'PageController');
    Route::get('pages/{id}/subpages','PageController@subPages')->name('subpages');
    Route::post('pages/checkurl','PageController@urlControl')->name('pages.checkurl');
    Route::resource('files' , 'FileController');
    Route::post('files/ajax','FileController@ajax')->name('file.ajax');
    Route::resource('languages' , 'LanguageController');
    Route::post('languages/update/extensions' , 'LanguageController@extensions')->name('update.Extensions');
    Route::post('languages/update/default' , 'LanguageController@changeDefault')->name('change.default');
    Route::post('languages/update/list','LanguageController@updateList')->name('updateList');
    Route::get('logs','LogController@index')->name('log-index');

    //Category
    Route::resource('categories','CategoryController');
    Route::post('category/order','CategoryController@order')->name('categories.order');
    Route::post('category/getCategory','CategoryController@getCategory')->name('get-category');
    Route::post('category/updateCategory','CategoryController@customUpdate')->name('update-category');
    Route::post('category/sortCategory','CategoryController@sortCategory')->name('sort-category');

    Route::resource('metas' , 'MetaController');
    Route::resource('redirects' , 'RedirectController');

    //Form-Ebulletin
    Route::resource('forms','FormController');
    Route::resource('forms.messages','MessageController');
    Route::resource('messages','MessageController')->only(['show','store']);
    Route::resource('ebulletins' , 'EbulletinController');

    //Auth
    Route::resource('users' , 'UserController');
    Route::resource('roles' , 'RoleController');

    Route::get('/','HomeController@index')->name('panel');

    Route::get('login',function (){ return view('auth/login');})->name('login');

    Route::get('getFilePage','FileController@getFilePage')->name('files.getFilePage');
    Route::get('getFilePageDetail','FileController@getFilePageDetail')->name('files.getFilePageDetail');

    Route::post('saveFilePage','FileController@saveFilePage')->name('files.saveFilePage');
    Route::post('saveFilePageDetail','FileController@saveFilePageDetail')->name('files.saveFilePageDetail');

    Route::post('uploadFile','FileController@uploadFile')->name('files.uploadFile');

    Route::get('googleAnalytics','AnalyticsController@google')->name('analytics.google');

    Route::resource('slider','SliderController');
    Route::post('slider/add-image','SliderController@addImage')->name('addImage');
    Route::post('slider/delete-image','SliderController@deleteImage')->name('delimage');
    Route::post('slider/get-slider-image','SliderController@getSliderImage')->name('getSliderImage');
    Route::post('slider/edit-image','SliderController@editImage')->name('editImage');
    Route::post('slider/sort-image','SliderController@sortImage')->name('sortImage');
    //Menu
    Route::resource('menu', 'MenuController');
    Route::post('menu/ajax','MenuController@ajax')->name('menuajax');
    Route::post('menu/item//delete','MenuController@destroyMenuItem')->name('delete-item');
    Route::post('menuitem/ajax/','MenuController@storeMenuItem')->name('menuitemajax');
    Route::post('menuitem/edit/ajax/','MenuController@editMenuItem')->name('edit-menuitem-ajax');
    Route::post('menu/item','MenuController@getMenuItem')->name('get-menuitem');

});

Route::get('w-admin/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('w-admin/login/', 'Auth\LoginController@login');
Route::post('w-admin/logout', 'Auth\LoginController@logout')->name('logout');


Route::group(['prefix'=>'ebulletin'],function(){
    Route::get('activate/{token}', 'ActionsController@activate')->name('ebulletin.activate');
    Route::get('cancel/{token}', 'ActionsController@cancel')->name('ebulletin.cancel');
    Route::post('save','ActionsController@save')->name('ebulletin.save');
});


Route::post('form/store','MessageController@store')->name('form');
Route::fallback('UrlController@url');

Route::get('/home', 'HomeController@index')->name('home');
Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
    ->name('ckfinder_connector');

Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
    ->name('ckfinder_browser');

