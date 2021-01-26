<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Envelop - {{$client->account->head_of_account}}</title>

    <style type="text/css">
        @page {margin: 100px;}
        body {margin: 10px;}
        * {font-family: Verdana, Arial, sans-serif;}
        a {text-decoration: none;}
        table {font-size: medium;}
    </style>
</head>
<body>

    <strong>{{$client->person}}</strong>
    <br>
    {{$client->account->head_of_account}}
    <br>
    {!! nl2br(e($client->address)) !!}

</body>
</html>
