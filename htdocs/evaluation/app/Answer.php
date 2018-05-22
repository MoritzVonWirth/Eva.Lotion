<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends BaseModel
{
    protected $primaryKey = 'id';
    protected $table = 'answer';
    protected $fillable = array('text', 'question', 'selected_answer');
}
