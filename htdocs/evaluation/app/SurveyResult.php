<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveyResult extends BaseModel
{
    protected $primaryKey = 'id';
    protected $table = 'survey_result';
    protected $fillable = array('email', 'survey', 'token', 'email', 'answers', 'processed');

    public function sendToken() {
        $transport = (new \Swift_SmtpTransport('ein host', 25))
            ->setUsername('user')
            ->setPassword('password')
        ;

        $mailer = new \Swift_Mailer($transport);
        $payload = '<html>'.
            '<body>'.
            '<a href="localhost:41225/survey/'.$this->token.'">Klick!</a>'.
            '</body>'.
            '</html>';
        var_dump($payload);
        //die();
        $message = (new \Swift_Message('Wonderful Subject'))
            ->setFrom(['eine E-mail Adresse' => 'Moritz von Wirth'])
            ->setTo([$this->email , $this->email => $this->email])
            ->setBody($payload, 'text/html')
        ;

// Send the message
        $result = $mailer->send($message);
    }
}
