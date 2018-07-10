<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParticipantUserCircle extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'participant_user_circle';
    protected $fillable = array('participant_id', 'user_circle_id');
}
