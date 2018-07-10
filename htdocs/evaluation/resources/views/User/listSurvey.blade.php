@extends('layouts.app')
@section('content')
<div class="listSurvey">
    <nav class="navbar navbar-default navbar-static-top" role="navigation">
        <div class="navbar-header">
            <a class="navbar-brand" href="/listSurvey"><h2>Eva.Lotion</h2></a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li class="btn btn-danger"><a class="logout" href="/logout">Ausloggen</a></li>
        </ul>
    </nav>
    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
            <th>Umfrage</th>
            <th>Status</th>
            <th>Start Datum</th>
            <th>End Datum</th>
            <th>Userkreis</th>
            <th>Fortschritt</th>
            <th>Bearbeiten</th>
            <th>Schließen</th>
            <th>Auswertung</th>
            <th>Löschen</th>
            <th>Ergebnisse teilen</th>
        </thead>
        <tbody>
            @foreach($surveys as $survey)
                <tr>
                    <td>{{$survey->title}}</td>
                    <td>Status</td>
                    @if($survey->getFormattedStartDate())
                        <td>{{$survey->getFormattedStartDate()}}</td>
                    @else
                        <td></td>
                    @endif
                    @if($survey->getFormattedEndDate())
                        <td>{{$survey->getFormattedEndDate()}}</td>
                    @else
                        <td></td>
                    @endif
                    <td>Userkreis</td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{$survey->getProgress()}}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </td>
                    @if($survey->is_closed)
                        <td><span class="fas fa-edit fa-2x deactivated"></span></td>
                    @else
                        <td><a href="/editSurvey/{{$survey->id}}"><span class="fas fa-edit fa-2x active"></span></a></td>
                    @endif
                    @if($survey->is_closed)
                        <td><span class="fas fa-window-close fa-2x deactivated"></span></td>
                    @else
                        <td><a href="/closeSurvey/{{$survey->id}}" ><span class="fas fa-window-close fa-2x active"></span></a></td>
                    @endif
                    @if($survey->is_closed)
                        <td><a href="/showEvaluation/{{$survey->id}}" ><span class="fas fa-bell fa-2x active"></span></a></td>
                    @else
                        <td><span class="fas fa-bell fa-2x deactivated"></span></td>
                    @endif
                    <td><a href="/deleteSurvey/{{$survey->id}}" ><span class="fas fa-trash-alt fa-2x active"></span></a></td>
                    @if($survey->is_closed)
                        <td><a href="/shareEvaluation/{{$survey->id}}" ><span class="fas fa-share-alt-square fa-2x active"></span></a></td>
                    @else
                        <td><span class="fas fa-share-alt-square fa-2x deactivated"></span></td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
    <form action="newSurvey" method="post">
        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
        <button class="btn btn-primary" type="submit"><i class="fas fa-file"></i> Neue Umfrage erstellen</button>
    </form>
</div>
@endsection