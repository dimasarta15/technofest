<?php

use Illuminate\Support\Facades\Route;
use PHPUnit\TextUI\XmlConfiguration\Group;

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
$locales = [
    'id',
    'en',
    '',
];

foreach ($locales as $locale) {
    if (!empty($locale)) {
        $as = "$locale.";
    } else {
        $as = "";
    }
    
    Route::group(['prefix' => $locale, 'as' => $as], function() {
        Route::group(['namespace' => 'Frontsite', 'as' => 'frontsite.'], function () {
            Route::get('/', [
                'uses' => 'HomeController@index',
                'as' => 'home.index'
            ]);
            
            Route::get('/participant/datatable', [
                'uses' => 'ParticipantController@datatable',
                'as' => 'participant.datatable'
            ]);
            Route::resource('participant', 'ParticipantController');

            Route::resource('quizioner', 'QuizionerController');
            Route::resource('project', 'ProjectController');
            Route::resource('user', 'UserController')->except(['index', 'show']);
            Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
                Route::get('/{email}', [
                    'uses' => 'UserController@index',
                    'as' => 'index'
                ]);
            });
            Route::resource('project-archive', 'ProjectArchiveController');
        /* 
            Route::group(['prefix' => 'project', 'as' => 'project.'], function () {
                Route::get('/{email}', [
                    'uses' => 'ProjectController@projectAuthor',
                    'as' => 'project-author'
                ]);

                Route::get('detail/{id}', [
                    'uses' => 'ProjectController@show',
                    'as' => 'show'
                ]);
            }); */
            Route::resource('event', 'EventController');
        });
    });
}