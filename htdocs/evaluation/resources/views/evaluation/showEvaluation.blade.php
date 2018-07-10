@extends('layouts.app')
@section('content')
<div class="showEvaluation">
    <a class="btn btn-danger back" href="/listSurvey">Zurück</a>
    <div class="col-lg-6">
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
            <th>Frage</th>
            <th>Antworten einsehen</th>
            </thead>
            <tbody>
            @foreach($questions as $question)
                <tr>
                    <td>{{$question->text}}</td>
                    @if(count($question->getAnswers()) > 0)
                        <td class="link"><a href="/showEvaluationStatistic/{{$question->id}}"><i class="fas fa-arrow-circle-right fa-2x active"></i></a></td>
                    @else
                        <td class="link"><i class="fas fa-arrow-circle-right fa-2x deactivated"></i></td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        <form action="/evaluationPDF/{{$id}}" method="post">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <input type="hidden" name="id" value="{{$id}}" />
            <button class="btn btn-success" type="submit"><i class="fas fa-download"></i> Auswertung herunterladen</button>
        </form>
    </div>
</div>
@endsection