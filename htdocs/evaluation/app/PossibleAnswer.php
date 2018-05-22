<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PossibleAnswer extends BaseModel
{
    protected $primaryKey = 'id';
    protected $table = 'possible_answer';
    protected $fillable = array('question', 'answers', 'text');
}
