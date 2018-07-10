<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCircle extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'user_circle';
    protected $fillable = array('name');

    public function getParticipants() {
        $participantUserCircles = \App\ParticipantUserCircle::where('user_circle_id', $this->id)->get();
        foreach ($participantUserCircles as $participantUserCircle) {
            $participantId = $participantUserCircle->participant_id;
            $participantsFromUserCircle[] = \App\Participant::where('id', $participantId)->get();
        }
        foreach ($participantsFromUserCircle as $participant) {
            $participants[] = $participant->first();
        }
        return $participantsFromUserCircle;
    }
}
