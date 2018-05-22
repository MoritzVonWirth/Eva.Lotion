<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyResult extends BaseModel
{
    protected $primaryKey = 'id';
    protected $table = 'survey_result';
    protected $fillable = array('email', 'survey', 'token', 'email', 'answers');

    public function sendToken() {
        $transport = (new \Swift_SmtpTransport('your mailout server', 25))
            ->setUsername('your username')
            ->setPassword('your password')
        ;

        $mailer = new \Swift_Mailer($transport);

        $message = (new \Swift_Message('Wonderful Subject'))
            ->setFrom(['an emailaddress' => 'a name'])
            ->setTo([$this->email , $this->email => $this->email])
            ->setBody('localhost:41225/survey/'.$this->token)
        ;

// Send the message
        $result = $mailer->send($message);
    }
}
