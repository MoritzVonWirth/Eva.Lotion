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
        <form action="authenticate" method="post">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <p>Benutzername:</p>
            <input type="text" name="name" />
            <p>Passwort:</p>
            <input type="password" name="password" /><br />
            <button class="btn btn-success" type="submit">Einloggen</button>
        </form>
    </div>
</div>
</body>
</html>