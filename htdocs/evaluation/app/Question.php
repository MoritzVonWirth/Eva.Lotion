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

    public function getAllPublic() {
        $questions = $this->where('public', 1)->get();
        return $questions;
    }
}
