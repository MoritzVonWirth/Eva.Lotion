<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Survey extends Controller
{
    /**
     * Displays the form for the creation of a new survey
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newSurvey() {
        $survey = new \App\Survey();
        return view('Survey/newSurvey', array('survey' => $survey));
    }

    /**
     * Creates a new Survey
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function createSurvey(Request $request) {
        $survey = $request['survey'];
        $command = $request['command'];
        if (array_key_exists('public', $survey)) {
            if($survey['public'] == 'on') {
                $public = 1;
            }
        } else {
            $public = 0;
        }
        $newSurvey = \App\Survey::create([
            'title' => $survey['title'],
            'public' => $public
        ]);
        if(is_array($command))
        {
            if(array_key_exists('addPart', $command)){
                reset($command['addPart']);
                foreach ($command['addPart'] as $surveyPartKey => $surveyParts) {
                    $newSurveyPart = \App\SurveyPart::create([
                        'title' => '',
                        'survey' => $newSurvey->id
                    ]);
                    $newSurvey->update([
                        'survey_parts' => count($newSurvey->getSurveyParts()) + 1
                    ]);
                }
            }
        }
        //\App\SurveyResult::create(['email' => $newSurvey['userPool'], 'survey' => $survey->id, 'token' => md5($newSurvey['userPool']+$survey->id)]);
        return redirect()->action('Survey@editSurvey', [$newSurvey]);
    }

    /**
     * @param integer $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editSurvey($id) {
        $survey = \App\Survey::find($id)->surveyToArray();
        return view('Survey/editSurvey', array('survey' => $survey));
    }

    public function updateSurvey(Request $request)
    {
        $survey = $request['survey'];
        $command = $request['command'];
        $surveyToUpdate = \App\Survey::find($survey['id']);
        if (array_key_exists('public', $survey)) {
            if($survey['public'] == 'on') {
                $public = 1;
            }
        } else {
            $public = 0;
        }
        $surveyToUpdate->update([
            'title' => $survey['title'],
            'public' => $public
        ]);
        if(array_key_exists('surveyParts', $survey)) {
            foreach ($survey['surveyParts'] as $surveyPartToUpdate) {
                $surveyPart = \App\SurveyPart::find($surveyPartToUpdate['id']);
                $surveyPart->update([
                    'title' => $surveyPartToUpdate['title']
                ]);
                if (array_key_exists('questions', $surveyPartToUpdate)) {
                    foreach ($surveyPartToUpdate['questions'] as $questionToUpdate) {
                        $question = \App\Question::find($questionToUpdate['id']);
                        $question->update([
                            'text' => $questionToUpdate['text']
                        ]);
                        if(array_key_exists('possibleAnswers', $questionToUpdate)) {
                            foreach ($questionToUpdate['possibleAnswers'] as $possibleAnswerToUpdate) {
                                $possibleAnswer = \App\PossibleAnswer::find($possibleAnswerToUpdate['id']);
                                $possibleAnswer->update([
                                    'text' => $possibleAnswerToUpdate['text']
                                ]);
                            }
                        }
                    }
                }
            }
        }
        $survey = $surveyToUpdate->surveyToArray();
        if(is_array($command)) {
            if(array_key_exists('addPart', $command)) {
                reset($command['addPart']);
                foreach ($command['addPart'] as $surveyPartKey => $surveyParts) {
                    $newSurveyPart = \App\SurveyPart::create([
                        'title' => '',
                        'survey' => $survey['id']
                    ]);
                    $surveyToUpdate->update([
                        'survey_parts' => count($surveyToUpdate->getSurveyParts()) + 1
                    ]);
                }
            }
            if(array_key_exists('addQuestion', $command)) {
                reset($command['addQuestion']);
                foreach($command['addQuestion'] as $surveyPartKey => $surveyParts)  {
                    foreach($command['addQuestion'][$surveyPartKey] as $questionKey => $questions) {
                        $newQuestion = \App\Question::create([
                            'text' => '',
                            'survey_part' => $survey['surveyParts'][$surveyPartKey]['id']
                        ]);
                        $surveyPartToUpdate = \App\SurveyPart::find($survey['surveyParts'][$surveyPartKey]['id']);
                        $surveyPartToUpdate->update([
                            'questions' => count($surveyPartToUpdate->getQuestions()) + 1
                        ]);
                    }
                }

            }
            if(array_key_exists('addPossibleAnswer', $command)) {
                reset($command['addPossibleAnswer']);
                foreach ($command['addPossibleAnswer'] as $surveyPartKey => $surveyParts) {
                    foreach ($command['addPossibleAnswer'][$surveyPartKey] as $questionKey => $questions) {
                        foreach ($command['addPossibleAnswer'][$surveyPartKey][$questionKey] as $possibleAnswerKey => $possibleAnswers) {
                            $newPossibleAnswer = \App\PossibleAnswer::create([
                                'text' => '',
                                'question' => $survey['surveyParts'][$surveyPartKey]['questions'][$questionKey]['id']
                            ]);
                            $questionToUpdate = \App\Question::find($survey['surveyParts'][$surveyPartKey]['questions'][$questionKey]['id']);
                            $questionToUpdate->update([
                               'possible_answers' => count($questionToUpdate->getPossibleAnswers()) + 1
                            ]);
                        }
                    }
                }
            }
            if (array_key_exists('saveSurvey', $command)) {
                foreach ($survey['userPool'] as $user) {
                    $token = md5($survey['userPool'].$survey['id']);
                    $surveyResult = \App\SurveyResult::create([
                        'email' => $survey['userPool'],
                        'token' => $token,
                        'survey' => $survey['id']
                    ]);
                }
                return redirect()->action('User@listSurvey');
            }
        }
        return redirect()->action('Survey@editSurvey', ['id' => $surveyToUpdate->id]);
    }
}
