<!DOCTYPE html>
<html>
    <head>
        <title>Eva.Lotion</title>
        <link href="css/main.css" rel="stylesheet">
    </head>
    <body class="evaluationPDF">
        <h1>{{$survey['title']}}</h1>
        <br />
        @foreach($survey['surveyParts'] as $surveyPart)
           <div class="surveyPart">
               <h2>{{$surveyPart['title']}}</h2>
               @foreach($surveyPart['questions'] as $question)
                   <div class="question">
                       <h3>{{$question['text']}}</h3>
                       @foreach($question['possibleAnswers'] as $possibleAnswer)
                           <div class="possibleAnswer">
                               {{$possibleAnswer['text']}}
                               <br />
                               {{$possibleAnswer['selectedAsAnswer']}} ({{$possibleAnswer['selectedAsAnswerPercentage']}}%)
                           </div>
                       @endforeach
                   </div>
               @endforeach
           </div>
        @endforeach
    </body>
</html>