<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <!-- Font Awesome -->
    <script defer src="{{ mix('js/fontawesome.js') }}"></script>

</head>
<body>
    <div id="app">

        @yield('content')

    </div>
</body>
</html>
