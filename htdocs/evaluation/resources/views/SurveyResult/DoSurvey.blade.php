<!DOCTYPE html>
<html>
<head>
    <title>Eva.Lotion</title>

    <link href="//fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'Arial';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 96px;
        }

        form {
            width: 200%;
            height: 200%;
        }
        button {
            float: right;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <form action="submitSurvey" method="post">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <h1>{{$survey->title}}</h1>
            @foreach($survey->getSurveyParts() as $surveyPart)
                <h3>{{$surveyPart->title}}</h3>
                <input type="hidden" name="survey[surveyResultId]" value="{{$surveyResult}}" />
                <input type="hidden" name="survey[surveyParts][{{$surveyPart->id}}]" />
                @foreach($surveyPart->getQuestions() as $question)
                    <p>{{$question->text}}</p>
                    <input type="hidden" name="survey[surveyParts][{{$surveyPart->id}}][questions][{{$question->id}}][questionId]"  value="{{$question->id}}"/>
                    @foreach($question->getPossibleAnswers() as $possibleAnswer)
                        {{$possibleAnswer->text}}
                        <input type="checkbox" name="survey[surveyParts][{{$surveyPart->id}}][questions][{{$question->id}}][chosenAnswer]" value="{{$possibleAnswer->id}}">
                    @endforeach
                @endforeach
            @endforeach
            <button type="submit">Umfrage absenden</button>
        </form>
    </div>
</div>
</body>
</html>