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
        <a href="listSurvey">Zurück</a>
        <form action="/updateSurvey" method="post">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <input type="hidden" name="survey[id]" value="{{$survey['id']}}" />
            <p>Titel: <input type="text" name="survey[title]" value="{{$survey['title']}}"/></p>
            @if($survey['public'] == 1)
                <p>Öffentlich? <input type="checkbox" name="survey[public]" disabled checked/></p>
            @else
                <p>Öffentlich? <input type="checkbox" name="survey[public]" /></p>
            @endif
            @if(isset($survey['surveyParts']) && count($survey['surveyParts']) > 0)
                @for($i = 0; $i < count($survey['surveyParts']); $i++)
                    Fragenteil {{$i +1}}<br />
                    <p>Titel: <input type="text" name="survey[surveyParts][{{$i}}][title]" value="{{$survey['surveyParts'][$i]['title']}} "/></p>
                    <input type="hidden" name="survey[surveyParts][{{$i}}][id]" value="{{$survey['surveyParts'][$i]['id']}}" />
                    @if(isset($survey['surveyParts'][$i]['questions']) && count($survey['surveyParts'][$i]['questions']) > 0)
                        @for($j = 0; $j < count($survey['surveyParts'][$i]['questions']); $j++)
                            <p>Frage: <input type="text" name="survey[surveyParts][{{$i}}][questions][{{$j}}][text]" value="{{$survey['surveyParts'][$i]['questions'][$j]['text']}} "/></p>
                            <input type="hidden" name="survey[surveyParts][{{$i}}][questions][{{$j}}][id]" value="{{$survey['surveyParts'][$i]['questions'][$j]['id']}}" />
                            @if(isset($survey['surveyParts'][$i]['questions'][$j]['possibleAnswers']) && count($survey['surveyParts'][$i]['questions'][$j]['possibleAnswers']) > 0)
                                @for($k = 0; $k < count($survey['surveyParts'][$i]['questions'][$j]['possibleAnswers']); $k++)
                                    <p>Antwort: <input type="text" name="survey[surveyParts][{{$i}}][questions][{{$j}}][possibleAnswers][{{$k}}][text]"  value="{{$survey['surveyParts'][$i]['questions'][$j]['possibleAnswers'][$k]['text']}}"/></p>
                                    <input type="hidden" name="survey[surveyParts][{{$i}}][questions][{{$j}}][possibleAnswers][{{$k}}][id]" value="{{$survey['surveyParts'][$i]['questions'][$j]['possibleAnswers'][$k]['id']}}" />
                                @endfor
                                <button type="submit" name="command[addPossibleAnswer][{{$i}}][{{$j}}][{{count($survey['surveyParts'][$i]['questions'][$j]['possibleAnswers'])}}]">Antwortmöglichkeit hinzufügen</button>
                            @else
                                <button type="submit" name="command[addPossibleAnswer][{{$i}}][{{$j}}][0]">Antwortmöglichkeit hinzufügen</button>
                            @endif
                        @endfor
                            <select name="command[addQuestionFromQuestionPool][{{$i}}]">
                                @foreach($questionsFromQuestionPool as $questionFromQuestionPool)
                                    <option value="{{$questionFromQuestionPool->id}}">{{$questionFromQuestionPool->text}}</option>
                                @endforeach
                            </select>
                            <button type="submit">Frage aus dem Fragenpool hinzufügen</button>
                            <button type="submit" name="command[addQuestion][{{$i}}][{{count($survey['surveyParts'][$i]['questions'])}}]">Frage hinzufügen</button>
                    @else
                        <button type="submit" name="command[addQuestion][{{$i}}][0]">Frage hinzufügen</button>
                    @endif
                @endfor
                <button type="submit" name="command[addPart][{{count($survey['surveyParts'])}}]">Teil hinzufügen</button>
            @else
                <button type="submit" name="command[addPart][0]">Teil hinzufügen</button>
            @endif

            <label>Userkreis</label>
            <select name="survey[userPool]">
                <option value="moritz.vonwirth@phth.de">Moritz</option>
                <option value="moritz.vonwirth@phth.de">Guess what... Moritz</option>
            </select>
            <button type="submit" name="command[saveSurvey]">Umfrage speichern</button>

        </form>
    </div>
</div>
</body>
</html>