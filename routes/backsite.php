<?php

use Illuminate\Support\Facades\Route;

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
        Route::group(['prefix' => 'backsite', 'namespace' => 'Backsite', 'as' => 'backsite.', 'middleware' => ['IsLoggedIn']], function () {
            //category
            Route::resource('category', 'CategoryController')->middleware(['can:access-superadmin-moderator']);
            Route::get('dtable-category', [
                'uses' => 'CategoryController@datatable',
                'as' => 'category.datatable'
            ])->middleware(['can:access-superadmin-moderator']);

            //langauge
            Route::resource('language', 'LanguageController')->middleware(['can:access-superadmin-moderator']);
            Route::get('dtable-language', [
                'uses' => 'LanguageController@datatable',
                'as' => 'language.datatable'
            ])->middleware(['can:access-superadmin-moderator']);

            //setting
            Route::get('/intro-setting', [
                'uses' => 'SettingController@intro',
                'as' => 'setting.intro'
            ]);

            //semester
            Route::resource('semester', 'SemesterController');
            Route::get('dtable-semester', [
                'uses' => 'SemesterController@datatable',
                'as' => 'semester.datatable'
            ]);
            Route::get('update-status/{id}', [
                'uses' => 'SemesterController@updateStatus',
                'as' => 'semester.update-status'
            ]);
            Route::post('update-position/{id}', [
                'uses' => 'SemesterController@updatePosition',
                'as' => 'semester.update-position'
            ]);

            Route::resource('year', 'YearController')->middleware(['can:access-superadmin-moderator']);
            Route::get('dtable-year', [
                'uses' => 'YearController@datatable',
                'as' => 'year.datatable'
            ]);

            //major
            Route::resource('major', 'MajorController')->middleware(['can:access-superadmin']);
            Route::get('dtable-major', [
                'uses' => 'MajorController@datatable',
                'as' => 'major.datatable'
            ])->middleware(['can:access-superadmin-moderator']);

            //role
            Route::resource('role', 'RoleController')->middleware(['can:access-superadmin']);
            Route::get('dtable-role', [
                'uses' => 'RoleController@datatable',
                'as' => 'role.datatable'
            ])->middleware(['can:access-superadmin-moderator']);

            //lecture
            Route::resource('lecture', 'LectureController')->middleware(['can:access-superadmin']);
            Route::get('dtable-lecture', [
                'uses' => 'LectureController@datatable',
                'as' => 'lecture.datatable'
            ])->middleware(['can:access-superadmin-moderator']);
            Route::get('/select2-get-lecture', [
                'uses' => 'LectureController@select2',
                'as' => 'select2.get-lecture'
            ]);
            
            //user
            Route::get('/user/my-profile', [
                'uses' => 'UserController@myProfile',
                'as' => 'user.my-profile'
            ]);
            Route::post('/user/update-profiles', [
                'uses' => 'UserController@updateProfile',
                'as' => 'user.update-profile'
            ]);
            Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => 'can:access-superadmin-moderator'], function () {
                Route::get('dtable-user', [
                    'uses' => 'UserController@datatable',
                    'as' => 'datatable'
                ]);
                Route::get('/create', [
                    'uses' => 'UserController@create',
                    'as' => 'create'
                ]);
                Route::get('/{id}/edit{role?}', [
                    'uses' => 'UserController@edit',
                    'as' => 'edit'
                ]);

                Route::get('/destroy/{id}/{role}', [
                    'uses' => 'UserController@destroy',
                    'as' => 'destroy'
                ]);
                Route::get('/{role?}', [
                    'uses' => 'UserController@index',
                    'as' => 'index'
                ]);
            });
            Route::resource('user', 'UserController')->except('index', 'create', 'edit', 'destroy')->middleware(['can:access-superadmin-moderator']);
            Route::get('/select2-get-user', [
                'uses' => 'UserController@select2',
                'as' => 'select2.get-user'
            ]);

            //project
            Route::resource('project', 'ProjectController')
                ->except('create', 'store', 'edit', 'show', 'update', 'destroy')
                ->middleware('participantVerified');
            Route::get('/dtable-project', [
                'uses' => 'ProjectController@datatable',
                'as' => 'project.datatable'
            ])->middleware('participantVerified');
            Route::group(['prefix' => 'project', 'as' => 'project.', 'middleware' => 'participantVerified'], function () {
                Route::get('/{semester}/list-project', [
                    'uses' => 'ProjectController@listProject',
                    'as' => 'list-project'
                ]);
                Route::get('/{semester}/create', [
                    'uses' => 'ProjectController@create',
                    'as' => 'create'
                ]);
                Route::get('/{semester}/{id}/edit', [
                    'uses' => 'ProjectController@edit',
                    'as' => 'edit'
                ]);
                Route::post('/{semester}/store', [
                    'uses' => 'ProjectController@store',
                    'as' => 'store'
                ]);
                Route::put('/{semester}/{id}/update', [
                    'uses' => 'ProjectController@update',
                    'as' => 'update'
                ]);
                Route::get('/{semester}/{id}/show', [
                    'uses' => 'ProjectController@show',
                    'as' => 'show'
                ]);
                Route::get('/{semester}/store-project', [
                    'uses' => 'ProjectController@store',
                    'as' => 'store-project'
                ]);
                Route::post('/store-image', [
                    'uses' => 'ProjectController@storeImage',
                    'as' => 'store-image'
                ]);

                Route::delete('/{id}/destroy-image', [
                    'uses' => 'ProjectController@destroyImage',
                    'as' => 'destroy-image'
                ]);

                Route::delete('/{semester}/{id}/destroy', [
                    'uses' => 'ProjectController@destroy',
                    'as' => 'destroy'
                ]);

                Route::get('/{semester}/{status}/export', [
                    'uses' => 'ProjectController@exportExcel',
                    'as' => 'export'
                ])->middleware(['can:access-superadmin-moderator']);

                Route::post('/update-status', [
                    'uses' => 'ProjectController@updateStatus',
                    'as' => 'update-status'
                ])->middleware(['can:access-superadmin-moderator']);
                
                Route::post('/set-approve', [
                    'uses' => 'ProjectController@setApprove',
                    'as' => 'set-approve'
                ])->middleware(['can:access-superadmin-moderator']);
            });

            //speaker
            Route::resource('speaker', 'SpeakerController')->middleware(['can:access-superadmin-moderator']);
            Route::get('/dtable-speaker', [
                'uses' => 'SpeakerController@datatable',
                'as' => 'speaker.datatable'
            ])->middleware(['can:access-superadmin-moderator']);
            
            //quizioner
            Route::resource('quizioner', 'QuizionerController')->except('create', 'store', 'edit', 'show', 'update', 'destroy')->middleware(['can:access-superadmin-moderator']);
            Route::group(['prefix' => 'quizioner', 'as' => 'quizioner.'], function () {
                Route::get('/dtable-quizioner', [
                    'uses' => 'QuizionerController@datatable',
                    'as' => 'datatable'
                ]);
                Route::get('/dtable-quizioner-response', [
                    'uses' => 'QuizionerController@datatableResponse',
                    'as' => 'datatable-quizioner-response'
                ]);
                Route::get('/{semester}/{id}/response', [
                    'uses' => 'QuizionerController@response',
                    'as' => 'response'
                ]);
                Route::get('/{semester}/list-quizioner', [
                    'uses' => 'QuizionerController@listQuizioner',
                    'as' => 'list-quizioner'
                ]);
                Route::get('/{semester}/create', [
                    'uses' => 'QuizionerController@create',
                    'as' => 'create'
                ]);
                Route::post('/{semester}/store', [
                    'uses' => 'QuizionerController@store',
                    'as' => 'store'
                ]);
                Route::get('/{semester}/{id}/edit', [
                    'uses' => 'QuizionerController@edit',
                    'as' => 'edit'
                ]);
                Route::put('/{semester}/{id}/update', [
                    'uses' => 'QuizionerController@update',
                    'as' => 'update'
                ]);
                Route::post('/get-option-quizioner', [
                    'uses' => 'QuizionerController@getOptions',
                    'as' => 'get-option-quizioner'
                ]);

                Route::delete('/destroy-option-quizioner', [
                    'uses' => 'QuizionerController@destroyOption',
                    'as' => 'destroy-option-quizioner'
                ]);

                Route::post('/check-has-response-quizioner', [
                    'uses' => 'QuizionerController@checkHasResponse',
                    'as' => 'check-has-response-quizioner'
                ]);
                
                Route::delete('/{semester}/{id}/destroy', [
                    'uses' => 'QuizionerController@destroy',
                    'as' => 'destroy'
                ]);

                Route::get('/{semester}/export', [
                    'uses' => 'QuizionerController@exportExcel',
                    'as' => 'export'
                ]);

                Route::post('/copas', [
                    'uses' => 'QuizionerController@copas',
                    'as' => 'copas'
                ]);
            });

            // event
            
            Route::resource('event', 'EventController')
                ->except('create', 'store', 'edit', 'show', 'update', 'destroy')
                ->middleware(['can:access-superadmin-moderator']);
            Route::get('/dtable-event', [
                'uses' => 'EventController@datatable',
                'as' => 'event.datatable'
            ])->middleware(['can:access-superadmin-moderator']);
            Route::group(['prefix' => 'event', 'as' => 'event.'], function () {
                Route::get('/{semester}/list-event', [
                    'uses' => 'EventController@listEvent',
                    'as' => 'list-event'
                ]);
                Route::get('/{semester}/create', [
                    'uses' => 'EventController@create',
                    'as' => 'create'
                ]);
                Route::get('/{semester}/{id}/edit', [
                    'uses' => 'EventController@edit',
                    'as' => 'edit'
                ]);
                Route::post('/{semester}/store', [
                    'uses' => 'EventController@store',
                    'as' => 'store'
                ]);
                Route::put('/{semester}/{id}/update', [
                    'uses' => 'EventController@update',
                    'as' => 'update'
                ]);
                Route::get('/{semester}/{id}/show', [
                    'uses' => 'EventController@show',
                    'as' => 'show'
                ]);
                Route::get('/{semester}/store-project', [
                    'uses' => 'EventController@store',
                    'as' => 'store-project'
                ]);
                Route::post('/store-image', [
                    'uses' => 'EventController@storeImage',
                    'as' => 'store-image'
                ]);

                Route::delete('/{id}/destroy-image', [
                    'uses' => 'EventController@destroyImage',
                    'as' => 'destroy-image'
                ]);

                Route::delete('/{semester}/{id}/destroy', [
                    'uses' => 'EventController@destroy',
                    'as' => 'destroy'
                    
                ]);
            });

            // agenda
            Route::resource('agenda', 'AgendaController')
                ->except('create', 'store', 'edit', 'show', 'update', 'destroy')
                ->middleware(['can:access-superadmin-moderator']);
            
            Route::group(['prefix' => 'agenda', 'as' => 'agenda.', 'middleware' => 'can:access-superadmin-moderator'], function () {
                Route::get('/{semester}/list-agenda', [
                    'uses' => 'AgendaController@listAgenda',
                    'as' => 'list-agenda'
                ]);
                Route::get('/{semester}/create', [
                    'uses' => 'AgendaController@create',
                    'as' => 'create'
                ]);
                Route::get('/{semester}/{id}/edit', [
                    'uses' => 'AgendaController@edit',
                    'as' => 'edit'
                ]);
                Route::post('/{semester}/store', [
                    'uses' => 'AgendaController@store',
                    'as' => 'store'
                ]);
                Route::put('/{semester}/{id}/update', [
                    'uses' => 'AgendaController@update',
                    'as' => 'update'
                ]);
                Route::get('/{semester}/{id}/show', [
                    'uses' => 'AgendaController@show',
                    'as' => 'show'
                ]);
                Route::get('/{semester}/store-project', [
                    'uses' => 'AgendaController@store',
                    'as' => 'store-project'
                ]);
                Route::post('/store-image', [
                    'uses' => 'AgendaController@storeImage',
                    'as' => 'store-image'
                ]);

                Route::delete('/{id}/destroy-image', [
                    'uses' => 'AgendaController@destroyImage',
                    'as' => 'destroy-image'
                ]);

                Route::delete('/{semester}/{id}/destroy', [
                    'uses' => 'AgendaController@destroy',
                    'as' => 'destroy'
                ]);
            });
            Route::get('/dtable-agenda', [
                'uses' => 'AgendaController@datatable',
                'as' => 'agenda.datatable'
            ])->middleware(['can:access-superadmin-moderator']);

            
            Route::group(['prefix' => 'backup', 'as' => 'backup.', 'middleware' => 'can:access-superadmin-moderator'], function () {
                Route::get('/', [
                    'uses' => 'BackupController@index',
                    'as' => 'index'
                ]);

                Route::get('/index', [
                    'uses' => 'BackupController@index',
                    'as' => 'index'
                ]);

                Route::get('/run', [
                    'uses' => 'BackupController@run',
                    'as' => 'run'
                ]);

                Route::get('/destroy/{file}', [
                    'uses' => 'BackupController@destroy',
                    'as' => 'destroy'
                ]);
            });


            // dashboard
            Route::resource('dashboard', 'DashboardController');
            //setting
            Route::resource('setting', 'SettingController')->middleware(['can:access-superadmin-moderator']);
        });
    });
}