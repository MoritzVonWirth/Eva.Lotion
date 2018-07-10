<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends BaseModel
{
    protected $primaryKey = 'id';
    protected $table = 'survey';
    protected $fillable = array('title', 'public', 'survey_parts', 'start_date', 'end_date', 'author', 'is_closed', 'deleted');

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
        $surveyArray['startDate'] = $this->getFormattedStartDate();
        $surveyArray['endDate'] = $this->getFormattedEndDate();
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

    public function surveyToArrayForEvaluation() {
        $surveyArray = array();
        $surveyArray['title'] = $this->title;
        $surveyParts = $this->getSurveyParts();
        $i = 0;
        foreach ($surveyParts as $surveyPart) {
            $surveyArray['surveyParts'][$i]['title'] = $surveyPart->title;
            $questions = $surveyPart->getQuestions();
            $j = 0;
            foreach ($questions as $question) {
                $surveyArray['surveyParts'][$i]['questions'][$j]['text'] = $question->text;
                $possibleAnswers = $question->getPossibleAnswers();
                $k = 0;
                foreach ($possibleAnswers as $possibleAnswer) {
                    $surveyArray['surveyParts'][$i]['questions'][$j]['possibleAnswers'][$k]['text'] = $possibleAnswer->text;
                    $surveyArray['surveyParts'][$i]['questions'][$j]['possibleAnswers'][$k]['id'] = $possibleAnswer->id;
                    $k++;
                }
                $answers = $question->getAnswers();
                $l = 0;
                foreach ($answers as $answer) {
                    $surveyArray['surveyParts'][$i]['questions'][$j]['answers'][$l]['selectedAnswer'] = $answer->selected_answer;
                    $l++;
                }
                foreach ($possibleAnswers as $possibleAnswer) {
                    $idToSearch = $possibleAnswer->id;
                    $countOccurring = 0;
                    foreach ($surveyArray['surveyParts'][$i]['questions'][$j]['answers'] as $answerKey => $answer) {
                        if($answer['selectedAnswer'] == $idToSearch) {
                            $countOccurring++;
                        }
                    }
                    foreach ($surveyArray['surveyParts'][$i]['questions'][$j]['possibleAnswers'] as $possibleAnswerToUpdateKey => $possibleAnswerToUpdate) {
                        if($possibleAnswerToUpdate['id'] == $idToSearch) {
                            $surveyArray['surveyParts'][$i]['questions'][$j]['possibleAnswers'][$possibleAnswerToUpdateKey]['selectedAsAnswer'] = $countOccurring;
                            $selectedAsAnswerPercentage = round(($countOccurring / count($question->getAnswers())) * 100, 0);
                            $surveyArray['surveyParts'][$i]['questions'][$j]['possibleAnswers'][$possibleAnswerToUpdateKey]['selectedAsAnswerPercentage'] = $selectedAsAnswerPercentage;
                        }
                    }
                }
                $j++;
            }
            $i++;
        }
        return $surveyArray;
    }

    public function getFormattedStartDate() {
        $startDate = \DateTime::createFromFormat('Y-m-d H:i:s', $this->start_date);
        if($startDate) {
            $startDate = $startDate->format('d-m-Y');
        }
        return $startDate;
    }

    public function getFormattedEndDate() {
        $endDate = \DateTime::createFromFormat('Y-m-d H:i:s', $this->end_date);
        if ($endDate) {
            $endDate = $endDate->format('d-m-Y');
        }
        return $endDate;
    }

    public function getProgress() {
        $surveyResults = \App\SurveyResult::where('survey', $this->id)->get();
        $all = count($surveyResults);
        $countProcessed = 0;
        foreach ($surveyResults as $surveyResult) {
            if($surveyResult->processed === 1) {
                $countProcessed++;
            }
        }
        if ($all > 0) {
            $progress = round(($countProcessed / $all) * 100, 2);
        } else {
            $progress = 0;
        }
        return $progress;
    }
}
