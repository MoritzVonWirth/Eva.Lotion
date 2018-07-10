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
    \App\User::create(array('name' => 'mvwirth', 'email' => 'moritz.vonwirth@blubb.de', 'password' => bcrypt('123456789')));
    $userCircle = \App\UserCircle::create(array('name' => 'testCircle123'));
    $participants = [];
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));

    foreach ($participants as $participant) {
        \App\ParticipantUserCircle::create(array('participant_id' => $participant['id'], 'user_circle_id' => $userCircle['id']));
    }

    $userCircle = \App\UserCircle::create(array('name' => 'ZweiterKreis'));
    $participants = [];
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));
    $participants[] = \App\Participant::create(array('email' => 'moritz.vonwirth@blubb.de'));

    foreach ($participants as $participant) {
        \App\ParticipantUserCircle::create(array('participant_id' => $participant['id'], 'user_circle_id' => $userCircle['id']));
    }

    return 'User created!';
});

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

Route::get('allReadyProcessed', 'SurveyResult@allReadyProcessed');

Route::post('newSurvey', ['middleware' => 'auth', 'uses' => 'Survey@newSurvey']);

Route::get('editSurvey/{id}', ['middleware' => 'auth', 'uses' => 'Survey@editSurvey']);

Route::get('closeSurvey/{id}', ['middleware' => 'auth', 'uses' => 'Survey@closeSurvey']);

Route::get('deleteSurvey/{id}', ['middleware' => 'auth', 'uses' => 'Survey@deleteSurvey']);

Route::get('showEvaluation/{id}', ['middleware' => 'auth', 'uses' => 'Evaluation@showEvaluation']);

Route::get('showEvaluationStatistic/{id}', ['middleware' => 'auth', 'uses' => 'Evaluation@showEvaluationStatistic']);

Route::post('editSurvey/{id}', ['middleware' => 'auth', 'uses' => 'Survey@editSurvey']);

Route::post('evaluationPDF/{id}', ['middleware' => 'auth', 'uses' => 'Evaluation@evaluationPDF']);

Route::get('shareEvaluation/{id}', ['middleware' => 'auth', 'uses' => 'Survey@shareEvaluation']);

Route::post('updateSurvey', ['middleware' => 'auth', 'uses' => 'Survey@updateSurvey']);

Route::post('authenticate', 'User@authenticate');

Route::post('createSurvey', ['middleware' => 'auth', 'uses' => 'Survey@createSurvey']);

Route::post('evaluationList', ['middleware' => 'auth', 'uses' => 'Evaluation@evaluationList']);

Route::post('evaluationList', ['middleware' => 'auth', 'uses' => 'Evaluation@evaluationList']);

Route::post('evaluationList', ['middleware' => 'auth', 'uses' => 'Evaluation@evaluationList']);