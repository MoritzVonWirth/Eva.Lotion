@extends('layouts.app')
@section('content')
    <div class="newSurvey">
        <a class="btn btn-danger back" href="/listSurvey">Zurück</a>
        <br />
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h2>Eva.Lotion</h2>
                </div>
                <div class="card-body">
                    <form action="/createSurvey" method="post">
                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                        <div class="row">
                            <div class="col-md-12">
                                <br />
                                <label>Titel</label>
                                <input type="text" name="survey[title]" value="{{$survey['title']}}" class="form-control"/>
                            </div>
                        </div>
                        @if($survey['public'] == 1)
                            <div class="row">
                                <div class="col-md-12">
                                    <br />
                                    <label>Öffentlich</label>
                                    <input type="checkbox" name="survey[public]" disabled checked/>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-md-12">
                                    <br />
                                    <label>Öffentlich</label>
                                    <input type="checkbox" name="survey[public]" />
                                </div>
                            </div>
                        @endif
                        @if(isset($survey['surveyParts']) && count($survey['surveyParts']) > 0)
                            @for($i = 0; $i < count($survey['surveyParts']); $i++)
                                <div class="row">
                                    <div class="col-md-12">
                                        <br />
                                        <div class="card">
                                            <div class="card-header">
                                                <h3>Fragenteil {{$i + 1}}</h3>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <br />
                                                        <label>Titel</label>
                                                        <input class="form-control" type="text" name="survey[surveyParts][{{$i}}][title]" value="{{$survey['surveyParts'][$i]['title']}} "/>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="survey[surveyParts][{{$i}}][id]" value="{{$survey['surveyParts'][$i]['id']}}" />
                                                @if(isset($survey['surveyParts'][$i]['questions']) && count($survey['surveyParts'][$i]['questions']) > 0)
                                                    @for($j = 0; $j < count($survey['surveyParts'][$i]['questions']); $j++)
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <br />
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h4>Frage {{$j + 1}}</h4>
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <br />
                                                                                <label>Frage</label>
                                                                                <input class="form-control" type="text" name="survey[surveyParts][{{$i}}][questions][{{$j}}][text]" value="{{$survey['surveyParts'][$i]['questions'][$j]['text']}} "/>
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden" name="survey[surveyParts][{{$i}}][questions][{{$j}}][id]" value="{{$survey['surveyParts'][$i]['questions'][$j]['id']}}" />
                                                                        @if(isset($survey['surveyParts'][$i]['questions'][$j]['possibleAnswers']) && count($survey['surveyParts'][$i]['questions'][$j]['possibleAnswers']) > 0)
                                                                            @for($k = 0; $k < count($survey['surveyParts'][$i]['questions'][$j]['possibleAnswers']); $k++)
                                                                                <div class="row">
                                                                                    <div class="col-md-12">
                                                                                        <br />
                                                                                        <div class="card">
                                                                                            <div class="card-header">
                                                                                                <h5>Antwortmöglichkeit {{$k + 1}}</h5>
                                                                                            </div>
                                                                                            <div class="card-body">
                                                                                                <div class="row">
                                                                                                    <div class="col-md-12">
                                                                                                        <br />
                                                                                                        <label>Antwort</label>
                                                                                                        <input class="form-control" type="text" name="survey[surveyParts][{{$i}}][questions][{{$j}}][possibleAnswers][{{$k}}][text]"  value="{{$survey['surveyParts'][$i]['questions'][$j]['possibleAnswers'][$k]['text']}}"/>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <input type="hidden" name="survey[surveyParts][{{$i}}][questions][{{$j}}][possibleAnswers][{{$k}}][id]" value="{{$survey['surveyParts'][$i]['questions'][$j]['possibleAnswers'][$k]['id']}}" />
                                                                            @endfor
                                                                            <br />
                                                                            <button class="btn btn-primary" type="submit" name="command[addPossibleAnswer][{{$i}}][{{$j}}][{{count($survey['surveyParts'][$i]['questions'][$j]['possibleAnswers'])}}]"><i class="fas fa-plus-circle"></i> Antwortmöglichkeit hinzufügen</button>
                                                                        @else
                                                                            <br />
                                                                            <button class="btn btn-primary" type="submit" name="command[addPossibleAnswer][{{$i}}][{{$j}}][0]"><i class="fas fa-plus-circle"></i> Antwortmöglichkeit hinzufügen</button>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endfor
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <br />
                                                            <select class="form-control" name="command[addQuestionFromQuestionPool][{{$i}}]">
                                                                <option selected></option>
                                                                @foreach($questionsFromQuestionPool as $questionFromQuestionPool)
                                                                    <option value="{{$questionFromQuestionPool->id}}">{{$questionFromQuestionPool->text}}</option>
                                                                @endforeach
                                                            </select>
                                                            <br />
                                                            <button class="btn btn-primary" type="submit"><i class="fas fa-plus-circle"></i> Frage aus dem Fragenpool hinzufügen</button>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <br />
                                                            <button class="btn btn-primary" type="submit" name="command[addQuestion][{{$i}}][{{count($survey['surveyParts'][$i]['questions'])}}]"><i class="fas fa-plus-circle"></i> Frage hinzufügen</button>
                                                        </div>
                                                    </div>
                                                @else
                                                    <br />
                                                    <button class="btn btn-primary" type="submit" name="command[addQuestion][{{$i}}][0]"><i class="fas fa-plus-circle"></i> Frage hinzufügen</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                            <br />
                            <button class="btn btn-primary" type="submit" name="command[addPart][{{count($survey['surveyParts'])}}]"><i class="fas fa-plus-circle"></i> Teil hinzufügen</button>
                        @else
                            <br />
                            <button class="btn btn-primary" type="submit" name="command[addPart][0]"><i class="fas fa-plus-circle"></i> Teil hinzufügen</button>
                        @endif
                        <hr />
                        <div class="row">
                            <div class="col-md-12">
                                <br />
                                <label>Userkreis</label>
                                <select class="form-control" name="survey[userPool]">
                                    @foreach($userCircles as $userCircle)
                                        <option value="{{$userCircle->id}}">{{$userCircle->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col-md-6">
                                <br />
                                <label>Startdatum</label>
                                <input type="date" class="form-control" name="survey[startDate]" value="{{$survey['startDate']}}">
                            </div>
                            <div class="col-md-6">
                                <br />
                                <label>Enddatum</label>
                                <input type="date" class="form-control" name="survey[endDate]" value="{{$survey['endDate']}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <br />
                                <button class="btn btn-success" type="submit" name="command[saveSurvey]"><i class="fas fa-save"></i> Umfrage speichern</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection