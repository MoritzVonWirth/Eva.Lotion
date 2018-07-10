<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Survey extends Controller
{
    /**
     * Displays the form for the creation of a new survey
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function newSurvey() {
        $survey = new \App\Survey();
        $userCircles = \App\UserCircle::all();
        return view('Survey/newSurvey', array('survey' => $survey, 'userCircles' => $userCircles));
    }

    /**
     * Creates a new Survey
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function createSurvey(Request $request) {
        $survey = $request['survey'];
        $command = $request['command'];
        if (array_key_exists('public', $survey)) {
            if($survey['public'] == 'on') {
                $public = 1;
            }
        } else {
            $public = 0;
        }
        $newSurvey = \App\Survey::create([
            'author' => \Auth::user()->name,
            'title' => $survey['title'],
            'public' => $public
        ]);
        if(is_array($command))
        {
            if(array_key_exists('addPart', $command)){
                reset($command['addPart']);
                foreach ($command['addPart'] as $surveyPartKey => $surveyParts) {
                    $newSurveyPart = \App\SurveyPart::create([
                        'title' => '',
                        'survey' => $newSurvey->id
                    ]);
                    $newSurvey->update([
                        'survey_parts' => count($newSurvey->getSurveyParts()) + 1
                    ]);
                }
            }
        }
        //\App\SurveyResult::create(['email' => $newSurvey['userPool'], 'survey' => $survey->id, 'token' => md5($newSurvey['userPool']+$survey->id)]);
        return redirect()->action('Survey@editSurvey', [$newSurvey]);
    }

    /**
     * @param integer $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editSurvey($id) {
        $survey = \App\Survey::find($id)->surveyToArray();
        $questionsFromQuestionPool = new \App\Question();
        $questionsFromQuestionPool = $questionsFromQuestionPool->getAllPublic();
        $userCircles = \App\UserCircle::all();
        return view('Survey/editSurvey', array('survey' => $survey, 'questionsFromQuestionPool' => $questionsFromQuestionPool, 'userCircles' => $userCircles));
    }

    public function updateSurvey(Request $request)
    {
        $survey = $request['survey'];
        $command = $request['command'];
        $surveyToUpdate = \App\Survey::find($survey['id']);
        if($surveyToUpdate->public == 1) {
            $surveyToUpdate->update([
                'title' => $survey['title']
            ]);
        } else {
            if (array_key_exists('public', $survey)) {
                if($survey['public'] == 'on' || $survey['public'] == "1") {
                    $public = 1;
                }
            } else {
                $public = 0;
            }
            $surveyToUpdate->update([
                'title' => $survey['title'],
                'public' => $public
            ]);
        }
        if (array_key_exists('startDate', $survey)) {
            $surveyToUpdate->update([
                'start_date' => $survey['startDate']
            ]);
        }
        if (array_key_exists('endDate', $survey)) {
            $surveyToUpdate->update([
                'end_date' => $survey['endDate']
            ]);
        }
        if(array_key_exists('surveyParts', $survey)) {
            foreach ($survey['surveyParts'] as $surveyPartToUpdate) {
                $surveyPart = \App\SurveyPart::find($surveyPartToUpdate['id']);
                $surveyPart->update([
                    'title' => $surveyPartToUpdate['title']
                ]);
                if (array_key_exists('questions', $surveyPartToUpdate)) {
                    if ($surveyToUpdate->public == 1) {
                        foreach ($surveyPartToUpdate['questions'] as $questionToUpdate) {
                            $question = \App\Question::find($questionToUpdate['id']);
                            $question->update([
                                'text' => $questionToUpdate['text'],
                                'public' => 1
                            ]);
                            if(array_key_exists('possibleAnswers', $questionToUpdate)) {
                                foreach ($questionToUpdate['possibleAnswers'] as $possibleAnswerToUpdate) {
                                    $possibleAnswer = \App\PossibleAnswer::find($possibleAnswerToUpdate['id']);
                                    $possibleAnswer->update([
                                        'text' => $possibleAnswerToUpdate['text']
                                    ]);
                                }
                            }
                        }
                    }
                    else {
                        foreach ($surveyPartToUpdate['questions'] as $questionToUpdate) {
                            $question = \App\Question::find($questionToUpdate['id']);
                            $question->update([
                                'text' => $questionToUpdate['text']
                            ]);
                            if(array_key_exists('possibleAnswers', $questionToUpdate)) {
                                foreach ($questionToUpdate['possibleAnswers'] as $possibleAnswerToUpdate) {
                                    $possibleAnswer = \App\PossibleAnswer::find($possibleAnswerToUpdate['id']);
                                    $possibleAnswer->update([
                                        'text' => $possibleAnswerToUpdate['text']
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }
        $survey = $surveyToUpdate->surveyToArray();
        if(is_array($command)) {
            if(array_key_exists('addPart', $command)) {
                reset($command['addPart']);
                foreach ($command['addPart'] as $surveyPartKey => $surveyParts) {
                    $newSurveyPart = \App\SurveyPart::create([
                        'title' => '',
                        'survey' => $survey['id']
                    ]);
                    $surveyToUpdate->update([
                        'survey_parts' => count($surveyToUpdate->getSurveyParts()) + 1
                    ]);
                }
            }
            if(array_key_exists('addQuestion', $command)) {
                reset($command['addQuestion']);
                foreach($command['addQuestion'] as $surveyPartKey => $surveyParts)  {
                    foreach($command['addQuestion'][$surveyPartKey] as $questionKey => $questions) {
                        $newQuestion = \App\Question::create([
                            'text' => '',
                            'survey_part' => $survey['surveyParts'][$surveyPartKey]['id']
                        ]);
                        $surveyPartToUpdate = \App\SurveyPart::find($survey['surveyParts'][$surveyPartKey]['id']);
                        $surveyPartToUpdate->update([
                            'questions' => count($surveyPartToUpdate->getQuestions()) + 1
                        ]);
                    }
                }
            }
            if(array_key_exists('addPossibleAnswer', $command)) {
                reset($command['addPossibleAnswer']);
                foreach ($command['addPossibleAnswer'] as $surveyPartKey => $surveyParts) {
                    foreach ($command['addPossibleAnswer'][$surveyPartKey] as $questionKey => $questions) {
                        foreach ($command['addPossibleAnswer'][$surveyPartKey][$questionKey] as $possibleAnswerKey => $possibleAnswers) {
                            $newPossibleAnswer = \App\PossibleAnswer::create([
                                'text' => '',
                                'question' => $survey['surveyParts'][$surveyPartKey]['questions'][$questionKey]['id']
                            ]);
                            $questionToUpdate = \App\Question::find($survey['surveyParts'][$surveyPartKey]['questions'][$questionKey]['id']);
                            $questionToUpdate->update([
                               'possible_answers' => count($questionToUpdate->getPossibleAnswers()) + 1
                            ]);
                        }
                    }
                }
            }
            if (array_key_exists('saveSurvey', $command)) {
                $userCircle = $request['survey']['userPool'];
                $userCircle = \App\UserCircle::find($userCircle);
                $participants = $userCircle->getParticipants();
                foreach ($participants as $participant) {
                    $participant = $participant->first();
                    $token = md5(sqrt(rand(1,100000)).$userCircle->id.sqrt(rand(1,100000)).$request['survey']['id'].decbin(rand(0,100000)).$participant->email.rand(0,100000));
                    $surveyResult = \App\SurveyResult::create([
                        'email' => $participant->email,
                        'token' => $token,
                        'survey' => $request['survey']['id']
                    ]);
                }
                return redirect()->action('User@listSurvey');
            }
            if (array_key_exists('addQuestionFromQuestionPool', $command)) {
                reset($command['addQuestionFromQuestionPool']);
                foreach($command['addQuestionFromQuestionPool'] as $surveyPartKey => $questionId)  {
                    if($questionId) {
                        $questionFromQuestionPool = \App\Question::find($questionId);
                        $newQuestion = \App\Question::create([
                            'text' => $questionFromQuestionPool->text,
                            'survey_part' => $survey['surveyParts'][$surveyPartKey]['id']
                        ]);
                        $surveyPartToUpdate = \App\SurveyPart::find($survey['surveyParts'][$surveyPartKey]['id']);
                        $surveyPartToUpdate->update([
                            'questions' => count($surveyPartToUpdate->getQuestions()) + 1
                        ]);
                    }
                }
            }
        }
        return redirect()->action('Survey@editSurvey', ['id' => $surveyToUpdate->id]);
    }

    /**
     * Sets a specific survey closed by its id
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function closeSurvey($id) {
        $survey = \App\Survey::find($id);
        $survey->update([
           'is_closed' => 1
        ]);
        return redirect()->action('User@listSurvey');
    }

    /**
     * Sets a specific survey as deleted by its id
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteSurvey($id) {
        $survey = \App\Survey::find($id);
        $survey->update([
            'deleted' => 1
        ]);
        return redirect()->action('User@listSurvey');
    }

    public function shareEvaluation($id) {
        $surveyResults = \App\SurveyResult::where('survey', $id)->get();
        $survey = \App\Survey::find($id);
        $survey = $survey->surveyToArrayForEvaluation();
        $attachment = View('evaluation/evaluationPDF', ['survey' => $survey])->render();
        $attachment = preg_replace('/>\s+</', '><', $attachment);
        $evaluation = new \Dompdf\Dompdf();
        $evaluation->loadHtml($attachment);
        $evaluation->setPaper('A4', 'portrait');
        $evaluation->render();
        $pdf = $evaluation->output();
        //$evaluation->stream();
        $attachment = new \Swift_Attachment(
            $pdf,
            'test.pdf',
            'application/pdf'
        );


        foreach ($surveyResults as $surveyResult) {
            $transport = (new \Swift_SmtpTransport('ein Host', 25))
                ->setUsername('user')
                ->setPassword('password')
            ;
            $mailer = new \Swift_Mailer($transport);
            $message = (new \Swift_Message('Wonderful Subject'))
                ->setFrom(['eine E-Mail Adresse' => 'Moritz von Wirth'])
                ->setTo([$surveyResult->email , $surveyResult->email => $surveyResult->email])
                ->setBody('' ,'text/html')
                ->attach($attachment)
            ;
            $result = $mailer->send($message);
        }
    }
}
