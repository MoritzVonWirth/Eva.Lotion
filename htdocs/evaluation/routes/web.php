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

Route::get('/insert', function() {
    \App\User::create(array('name' => 'mvwirth', 'email' => 'moritz.vonwirth@phth.de', 'password' => bcrypt('123456789')));
    return 'User created!';
});
/**
 * Get
 */
Route::get('/', 'User@login');

Route::get('email', function () {
    $surveyResults = \App\SurveyResult::all();
    foreach ($surveyResults as $surveyResult) {
        $surveyResult->sendToken();
    }
});

Route::get('survey/{token}', 'SurveyResult@doSurvey');

Route::post('survey/submitSurvey', 'SurveyResult@submitSurvey');

Route::get('logout', function() {
    Auth::Logout();
    return Redirect::to('/');
});

Route::get('listSurvey', ['middleware' => 'auth', 'uses' => 'User@listSurvey']);

Route::get('processedSuccessfully', 'SurveyResult@processedSuccessfully');

/**
 * Post
 */
Route::post('newSurvey', ['middleware' => 'auth', 'uses' => 'Survey@newSurvey']);

Route::get('editSurvey/{id}', ['middleware' => 'auth', 'uses' => 'Survey@editSurvey']);

Route::post('editSurvey/{id}', ['middleware' => 'auth', 'uses' => 'Survey@editSurvey']);

Route::post('updateSurvey', ['middleware' => 'auth', 'uses' => 'Survey@updateSurvey']);

Route::post('authenticate', 'User@authenticate');

Route::post('createSurvey', ['middleware' => 'auth', 'uses' => 'Survey@createSurvey']);

Route::post('evaluationList', ['middleware' => 'auth', 'uses' => 'Evaluation@evaluationList']);

Route::post('evaluationList', ['middleware' => 'auth', 'uses' => 'Evaluation@evaluationList']);

Route::post('evaluationList', ['middleware' => 'auth', 'uses' => 'Evaluation@evaluationList']);