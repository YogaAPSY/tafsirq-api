<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['middleware' => ['auth.api']] ,function ($api) {
    $api->get('search/{keyword}', 'App\Api\V1\Controllers\SearchController@search');
    $api->get('popular', 'App\Api\V1\Controllers\SearchController@popularSearch');
    $api->get('hadits', 'App\Api\V1\Controllers\HaditsController@index');
    $api->get('hadits/{slug}', 'App\Api\V1\Controllers\HaditsController@show');
    $api->get('hadits/{slug}/all', 'App\Api\V1\Controllers\HaditsController@items');
    $api->get('hadits/{slug}/{id}', 'App\Api\V1\Controllers\HaditsController@item');
    $api->get('quran/surah', 'App\Api\V1\Controllers\QuranController@index');
    $api->get('quran/surah/{id}/ayah', 'App\Api\V1\Controllers\QuranController@show');
    $api->get('quran/surah/{id}/ayah/all', 'App\Api\V1\Controllers\QuranController@items');
    $api->get('quran/surah/{surah_id}/ayah/{ayah_id}', 'App\Api\V1\Controllers\QuranController@item');
    $api->get('quran/medina/{page}', 'App\Api\V1\Controllers\QuranController@juzPage');
    $api->get('quran/medina/surat/{surah_id}', 'App\Api\V1\Controllers\QuranController@juzSurah');
    $api->get('quran/medina/juz/{id}', 'App\Api\V1\Controllers\QuranController@juz');
    $api->get('konten/{slug_category}', 'App\Api\V1\Controllers\ContentController@items');
    $api->get('konten/{slug_category}/{slug}', 'App\Api\V1\Controllers\ContentController@item');
});