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
            display: table-cell;
        }

        .header {
            text-align: right;
            margin: 20px 20px;
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
    <div class="header">
        <a href="/logout">Ausloggen</a>
    </div>
    <div class="content">
        <table>
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
            <body>
                @foreach($surveys as $survey)
                    <tr>
                        <td>{{$survey->title}}</td>
                        <td>Status</td>
                        <td>Start Datum</td>
                        <td>End Datum</td>
                        <td>Userkreis</td>
                        <td>Fortschritt</td>
                        <td><a href="/editSurvey/{{$survey->id}}" >x</a></td>
                        <td>x</td>
                        <td>x</td>
                        <td>x</td>
                        <td>share</td>
                    </tr>
                @endforeach
            </body>
        </table>
        <form action="newSurvey" method="post">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <button type="submit">Neue Umfrage erstellen</button>
        </form>
    </div>
</div>
</body>
</html>