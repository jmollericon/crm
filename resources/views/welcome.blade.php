<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CRM|Laravel</title>
        <link href="{{asset('css/app.css')}}" rel="stylesheet">
    </head>
    <body class="antialiased">
        <div id="app">
            <example-component />
        </div>
        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
