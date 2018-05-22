<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends BaseModel
{
    protected $primaryKey = 'id';
    protected $table = 'survey';
    protected $fillable = array('title', 'public', 'survey_parts', 'start_date', 'end_date', 'author');

    public function getSurveyParts() {
        $surveyParts = \App\SurveyPart::where('survey', $this->id)->get();
        return $surveyParts;
    }

    /**
     * Converts the survey with all his objects to an array
     *
     * @return array
     */
    public function surveyToArray() {
        $surveyArray = array();
        $surveyArray['title'] = $this->title;
        $surveyArray['public'] = $this->public;
        $surveyArray['userPool'] = $this->userPool;
        $surveyArray['id'] = $this->id;
        $surveyParts = $this->getSurveyParts();
        $i = 0;
        foreach ($surveyParts as $surveyPart) {
            $surveyArray['surveyParts'][$i]['title'] = $surveyPart->title;
            $surveyArray['surveyParts'][$i]['id'] = $surveyPart->id;
            $questions = $surveyPart->getQuestions();
            $j = 0;
            foreach ($questions as $question) {
                $surveyArray['surveyParts'][$i]['questions'][$j]['text'] = $question->text;
                $surveyArray['surveyParts'][$i]['questions'][$j]['id'] = $question->id;
                $possibleAnswers = $question->getPossibleAnswers();
                $k = 0;
                foreach ($possibleAnswers as $possibleAnswer) {
                    $surveyArray['surveyParts'][$i]['questions'][$j]['possibleAnswers'][$k]['text'] = $possibleAnswer->text;
                    $surveyArray['surveyParts'][$i]['questions'][$j]['possibleAnswers'][$k]['id'] = $possibleAnswer->id;
                    $k++;
                }
                $j++;
            }
            $i++;
        }
        return $surveyArray;
    }
}
