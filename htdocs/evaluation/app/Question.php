<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends BaseModel
{
    protected $primaryKey = 'id';
    protected $table = 'question';
    protected $fillable = array('text', 'survey_part', 'possible_answers', 'type', 'answers', 'public');

    public function getPossibleAnswers() {
        $possibleAnswers = \App\PossibleAnswer::where('question', $this->id)->get();
        return $possibleAnswers;
    }

    public function getAnswers() {
        $answers = \App\Answer::where('question', $this->id)->get();
        return $answers;
    }

    public function getAllPublic() {
        $questions = $this->where([
            ['public', '=', 1],
            ['text', "!=", NULL]
            ])->get();
        return $questions;
    }

    public function getQuestionStatistic() {
        $questionStatistic = [];
        $questionStatistic['questionId'] = $this->id;
        $questionStatistic['questionText'] = $this->text;
        $surveyPart = \App\SurveyPart::find($this->survey_part);
        $questionStatistic['surveyId'] = $surveyPart->survey;
        $answers = $this->getAnswers();
        foreach ($answers as $answer) {
            if($answer->text) {
                $questionStatistic['answers'][] = $answer->text;
            } else {
                $answer = \App\PossibleAnswer::find($answer->selected_answer);
                $questionStatistic['answers'][] = $answer->text;
            }
        }
        return $questionStatistic;
    }
}
