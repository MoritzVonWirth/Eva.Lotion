<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class Evaluation extends Controller
{
    public function showEvaluation($id) {
        $survey = \App\Survey::find($id);
        $surveyParts = $survey->getSurveyParts();
        $questions= [];
        foreach ($surveyParts as $surveyPart) {
            $surveyPartQuestions = $surveyPart->getQuestions();
            foreach ($surveyPartQuestions as $surveyPartQuestion) {
                $questions[] = $surveyPartQuestion;
            }
        }
        return view('evaluation/showEvaluation', ['questions' => $questions, 'id' => $id]);
    }

    public function showEvaluationStatistic($questionId) {
        $question = \App\Question::find($questionId);
        $questionStatistic = $question->getQuestionStatistic();
        return \view('evaluation/showEvaluationStatistic', ['questionStatistic' => $questionStatistic]);
    }

    public function evaluationView() {

    }

    public function evaluationPDF($id)
    {
        $survey = \App\Survey::find($id);
        $survey = $survey->surveyToArrayForEvaluation();
        $html = View('evaluation/evaluationPDF', ['survey' => $survey])->render();
        $html = preg_replace('/>\s+</', '><', $html);
        $evaluation = new \Dompdf\Dompdf();
        $evaluation->loadHtml($html);
        $evaluation->setPaper('A4', 'portrait');
        $evaluation->render();
        $evaluation->stream();
        die();
    }
}
