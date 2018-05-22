<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SurveyResult extends Controller
{
    public function doSurvey($token) {
        $surveyResult = \App\SurveyResult::where('token', $token)->get();
        $surveyResult = $surveyResult->first();
        if ($surveyResult->processed == 1) {
            return redirect('allReadyProcessed');
        }
        $survey = \App\Survey::find($surveyResult->survey);
        return view('SurveyResult/DoSurvey', ['survey' => $survey, 'surveyResult' => $surveyResult->id]);
    }

    public function submitSurvey(Request $request) {
        $i = 0;
        foreach ($request['survey']['surveyParts'] as $surveyPart) {
            foreach ($surveyPart['questions'] as $question) {
                $i++;
                \App\Answer::create([
                    'question' => intval($question['questionId']),
                    'selected_answer' => intval($question['chosenAnswer'])
                ]);
                $possibleAnswer = \App\PossibleAnswer::find($question['chosenAnswer']);
                $answers = $possibleAnswer->answers + 1;
                $possibleAnswer->update(['answers' => $answers]);
            }
        }
        $surveyResult = \App\SurveyResult::find($request['survey']['surveyResultId']);
        $surveyResult = $surveyResult->first();
        $surveyResult->update(['answers' => $i, 'processed' => 1]);
        return redirect('processedSuccessfully');
    }

    public function processedSuccessfully() {
        return view('SurveyResult/processedSuccessfully');
    }

    public function allReadyProcessed() {
        return view('SurveyResult/allReadyProcessed');
    }
}
