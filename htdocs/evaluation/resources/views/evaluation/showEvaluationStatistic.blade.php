@extends('layouts.app')
@section('content')
<a class="btn btn-danger back" href="/showEvaluation/{{$questionStatistic['surveyId']}}">Zurück</a>
<div class="showEvaluationStatistic">
    <div class="col-lg-6">
        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
            <thead>
                <th>{{$questionStatistic['questionText']}}</th>
            </thead>
            <tbody>
                @foreach($questionStatistic['answers'] as $answer)
                    <tr>
                        <td>
                            {{$answer}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection