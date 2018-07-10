@extends('layouts.app')
@section('content')
    {{$surveyResult}}
<div class="doSurvey">
    <div class="col-lg-6">
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
@endsection