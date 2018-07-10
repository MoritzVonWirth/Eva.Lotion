<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'participant';
    protected $fillable = array('email');
}
