<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyPart extends BaseModel
{
    protected $primaryKey = 'id';
    protected $table = 'survey_part';
    protected $fillable = array('title', 'questions', 'survey');

    public function getQuestions() {
        $questions = \App\Question::where('survey_part', $this->id)->get();
        return $questions;
    }
}
