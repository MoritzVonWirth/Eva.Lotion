<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyResult extends BaseModel
{
    protected $primaryKey = 'id';
    protected $table = 'survey_result';
    protected $fillable = array('email', 'survey', 'token', 'email', 'answers', 'processed');

    public function sendToken() {
        $transport = (new \Swift_SmtpTransport('wp10624023.mailout.server-he.de', 25))
            ->setUsername('wp10624023-mvwirth')
            ->setPassword('747002aa!')
        ;

        $mailer = new \Swift_Mailer($transport);

        $message = (new \Swift_Message('Wonderful Subject'))
            ->setFrom(['moritz.vonwirth@phth.de' => 'Moritz von Wirth'])
            ->setTo([$this->email , $this->email => $this->email])
            ->setBody('localhost:41225/survey/'.$this->token)
        ;

// Send the message
        $result = $mailer->send($message);
    }
}
