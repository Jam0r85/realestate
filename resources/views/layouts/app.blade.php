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
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/all.css') }}" rel="stylesheet">

    <style type="text/css">
        @auth
            body {
                @if ($setting = user_setting(Auth::user(), 'font_override'))
                    font-family: "{{ $setting }}" !important;
                @endif
                @if ($setting = user_setting(Auth::user(), 'font_override_size'))
                    font-size: {{ $setting }} !important;
                @endif
            }
            input, textarea, select, button:not(.close), .dropdown-menu {
                @if ($setting = user_setting(Auth::user(), 'font_override_size'))
                    font-size: {{ $setting }} !important;
                @endif
            }
        @endauth
    </style>
</head>
<body>
    <div id="app">

        <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-5">

            <a class="navbar-brand" href="{{ route('dashboard') }}">
                {{ get_setting('company_name', config('app.name', 'Laravel')) }}
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle Navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mr-auto">

                    @auth

                        <li class="nav-item dropdown">

                            @component('partials.bootstrap.dropdown-toggle')
                                Planner
                                @slot('id')
                                    plannerDropdown
                                @endslot
                            @endcomponent

                            <div class="dropdown-menu" aria-labelledby="plannerDropdown">
                                <a class="dropdown-item" href="{{ route('calendars.index') }}">
                                    Calendars
                                </a>
                                <a class="dropdown-item" href="{{ route('events.index') }}">
                                    Events
                                </a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">

                            @component('partials.bootstrap.dropdown-toggle')
                                Users
                                @slot('id')
                                    usersDropdown
                                @endslot
                            @endcomponent

                            <div class="dropdown-menu" aria-labelledby="usersDropdown">
                                <a class="dropdown-item" href="{{ route('users.index') }}">
                                    Users List
                                </a>
                                <a class="dropdown-item" href="{{ route('users.archived') }}">
                                    Archived Users
                                </a>
                                <a class="dropdown-item" href="{{ route('bank-accounts.index') }}">
                                    Bank Accounts List
                                </a>
                            </div>

                        </li>

                        <li class="nav-item dropdown">

                            @component('partials.bootstrap.dropdown-toggle')
                                Properties
                                @slot('id')
                                    propertiesDropdown
                                @endslot
                            @endcomponent

                            <div class="dropdown-menu" aria-labelledby="usersDropdown">
                                <a class="dropdown-item" href="{{ route('properties.index') }}">
                                    Properties List
                                </a>
                                <a class="dropdown-item" href="{{ route('expenses.index') }}">
                                    Expenses List
                                </a>
                            </div>

                        </li>

                        <li class="nav-item dropdown">

                            @component('partials.bootstrap.dropdown-toggle')
                                Payments
                                @slot('id')
                                    paymentsDropdown
                                @endslot
                            @endcomponent

                            <div class="dropdown-menu" aria-labelledby="paymentsDropdown">
                                <a class="dropdown-item" href="{{ route('rent-payments.index') }}">
                                    Rent Payments
                                </a>
                                <a class="dropdown-item" href="{{ route('deposit-payments.index') }}">
                                    Deposit Payments
                                </a>
                                <a class="dropdown-item" href="{{ route('invoice-payments.index') }}">
                                    Invoice Payments
                                </a>
                            </div>

                        </li>

                        <li class="nav-item dropdown">

                            @component('partials.bootstrap.dropdown-toggle')
                                Tenancies
                                @slot('id')
                                    tenanciesDropdown
                                @endslot
                            @endcomponent

                            <div class="dropdown-menu" aria-labelledby="usersDropdown">
                                <a class="dropdown-item" href="{{ route('tenancies.index') }}">
                                    Tenancies List
                                </a>
                                <a class="dropdown-item" href="{{ route('tenancies.overdue') }}" title="Overdue Tenancies List">
                                    Overdue Tenancies
                                </a>
                                <a class="dropdown-item" href="{{ route('tenancies.archived') }}" title="Archived Tenancies List">
                                    Archived Tenancies
                                </a>
                                <a class="dropdown-item" href="{{ route('services.index') }}" title="Tenancy Services">
                                    Services
                                </a>
                                <div class="dropdown-divider"></div>
                                <h6 class="dropdown-header">Statements</h6>
                                <a class="dropdown-item" href="{{ route('statements.index') }}">
                                    Statements List
                                </a>
                                <a class="dropdown-item" href="{{ route('statement-payments.index') }}">
                                    Statement Payments List
                                </a>
                                <div class="dropdown-divider"></div>
                                <h6 class="dropdown-header">Deposits</h6>
                                <a class="dropdown-item" href="{{ route('deposit.index') }}" title="Deposits List">
                                    Deposits List
                                </a>
                                <a class="dropdown-item" href="{{ route('deposit.archived') }}" title="Archived Deposits">
                                    Archived Deposits
                                </a>
                                <div class="dropdown-divider"></div>
                                <h6 class="dropdown-header">Management</h6>
                                <a class="dropdown-item" href="{{ route('gas-safe.index') }}" title="Gas Inspections">
                                    Gas Inspections
                                </a>
                                <a class="dropdown-item" href="{{ route('gas-safe.archived') }}" title="Completed Gas Inspections">
                                    Completed Gas Inspections
                                </a>
                            </div>

                        </li>

                        <li class="nav-item dropdown">

                            @component('partials.bootstrap.dropdown-toggle')
                                Invoices
                                @slot('id')
                                    invoicesDropdown
                                @endslot
                            @endcomponent

                            <div class="dropdown-menu" aria-labelledby="usersDropdown">
                                <a class="dropdown-item" href="{{ route('invoices.index') }}">
                                    Invoices List
                                </a>
                                <a class="dropdown-item" href="{{ route('invoice-groups.index') }}">
                                    Invoice Groups List
                                </a>
                            </div>

                        </li>

                    @endauth

                </ul>
                <ul class="navbar-nav">

                    @auth
                        <li class="nav-item dropdown">

                            @component('partials.bootstrap.dropdown-toggle')
                                {{ Auth::user()->name }}
                                @slot('id')
                                    loginDropdown
                                @endslot
                            @endcomponent

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="usersDropdown">
                                <a class="dropdown-item" href="{{ route('users.show', Auth::user()->id) }}">
                                    My Profile
                                </a>
                                <a class="dropdown-item" href="{{ route('settings.general') }}">
                                    Application Settings
                                </a>
                                <a class="dropdown-item" href="{{ route('branches.index') }}">
                                    Branches
                                </a>
                                <a class="dropdown-item" href="{{ route('reports.index') }}">
                                    Reports
                                </a>
                                <a class="dropdown-item" href="{{ route('emails.index') }}">
                                    Sent E-Mails
                                </a>
                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form role="form" method="POST" action="{{ route('logout') }}" id="logout-form">
                                    {{ csrf_field() }}
                                </form>
                            </div>

                        </li>

                    @endauth

                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                Login
                            </a>
                        </li>
                    @endguest

                </ul>
            </div>
        </nav>

        <div class="container">            
            @include('flash::message')
        </div>

        <div class="mb-5">
            @yield('content')
        </div>

    </div>

    <div id="modalContainer"></div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script>
        $('.select2').select2();
    </script>

    @stack('footer_scripts')
</body>
</html>
