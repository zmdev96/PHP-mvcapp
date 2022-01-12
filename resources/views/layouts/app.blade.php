<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{@$title}}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        @yield('content_css')
        <link href="/css/app.css" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>

        </style>
    </head>
    <body>

@yield('content')
@yield('content_js')

</body>
</html>
