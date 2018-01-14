<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ get_setting('company_name', config('app.name', 'Laravel')) }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <!-- Font Awesome -->
    <script defer src="{{ mix('js/fontawesome.js') }}"></script>

    @stack('style')
</head>
<body>
    <div id="app">

        @include('layouts.navbar')

        @if (auth()->check())
            @if (!get_setting('settings_updated'))
                @component('partials.alerts.danger')
                    @slot('style')
                        mb-0
                    @endslot
                    <div class="text-center">
                        <p>
                            <b>Fresh install detected</b> - please complete setup by clicking the button below.
                        </p>
                        <a href="#" class="btn btn-danger">
                            @icon('cogs') Complete Setup
                        </a>
                    </div>
                @endcomponent
            @endif
        @endif

        <div class="mb-5">
            @yield('content')
        </div>

    </div>

    <div id="modalContainer"></div>

    @include('flash::message')

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script>
        $('.select2').select2();
        // $('li.alert').not('.alert-important').delay(3000).fadeOut(350);
    </script>

    @stack('footer_scripts')
</body>
</html>
