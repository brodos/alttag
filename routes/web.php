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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');



// Authenticated routes
Route::middleware('auth')->group(function () {

	Route::get('/home', 'HomeController@index')->name('home');

	Route::resource('sites', 'SitesController')->names([
		'index' => 'user-sites.index',
		'create' => 'user-sites.create',
		'store' => 'user-sites.store',
		'show' => 'user-sites.show',
		'edit' => 'user-sites.edit',
		'update' => 'user-sites.update',
		'destroy' => 'user-sites.delete',
	]);

	Route::resource('sites/{site}/urls', 'UrlsController')->only(['index', 'show', 'destroy'])->names([
		'index' => 'user-urls.index',
		'show' => 'user-urls.show',
		'destroy' => 'user-urls.delete',
	]);

	Route::resource('sites/{site}/images', 'ImagesController')->only(['index', 'show', 'destroy'])->names([
		'index' => 'user-images.index',
		'show' => 'user-images.show',
		'destroy' => 'user-images.delete',
	]);

	Route::get('sites/{site}/crawl/{url}', 'CrawlController@crawl')->name('crawl-url');
	Route::get('sites/{site}/crawl-now/{url}', 'CrawlController@crawlNow')->name('crawl-url-2');
});
