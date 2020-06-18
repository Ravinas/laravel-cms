<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::prefix('/panel')->middleware('auth')->group( function () {
    Route::resource('pages' , 'PageController');
    Route::get('pages/{id}/subpages','PageController@subPages')->name('subpages');
    Route::post('pages/checkurl','PageController@urlControl')->name('pages.checkurl');
    Route::resource('files' , 'FileController');
    Route::post('files/ajax','FileController@ajax')->name('file.ajax');
    Route::resource('languages' , 'LanguageController');
    Route::resource('categories','CategoryController');
    Route::post('category/order','CategoryController@order')->name('categories.order');

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
    //Menu
    Route::resource('menu', 'MenuController');
    Route::post('menu/ajax','MenuController@ajax')->name('menuajax');
    Route::get('menu/item/{menuitem}/delete','MenuController@destroyMenuItem')->name('delete-item');
    Route::post('menuitem/ajax/','MenuController@storeMenuItem')->name('menuitemajax');

});

Route::get('panel/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('panel/login/', 'Auth\LoginController@login');
Route::post('panel/logout', 'Auth\LoginController@logout')->name('logout');


Route::group(['prefix'=>'ebulletin'],function(){
    Route::get('activate/{token}', 'EbulletinController@activate')->name('ebulletin-activate');
    Route::get('cancel/{token}', 'EbulletinController@cancel')->name('ebulletin-cancel');
    Route::post('store','EbulletinController@store')->name('ebulletin-store');
});


Route::post('form/store','MessageController@store')->name('form');
Route::fallback('UrlController@url');

Route::get('/home', 'HomeController@index')->name('home');
Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
    ->name('ckfinder_connector');

Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
    ->name('ckfinder_browser');

