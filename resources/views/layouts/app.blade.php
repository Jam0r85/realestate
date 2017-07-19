<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ getSetting('company_name', config('app.name', 'Laravel')) }}</title>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
     <link href="{{ mix('css/all.css') }}" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">

        <div class="container">
            <nav class="navbar">
                <div class="navbar-brand">
                    <a class="navbar-item" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>

                    <div class="navbar-burger burger" data-target="navMenuExample">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>

                <div id="navMenuExample" class="navbar-menu">
                    <div class="navbar-start">
                        <a class="navbar-item" href="{{ url('/') }}">
                            Home
                        </a>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link is-active" href="#">
                                Planner
                            </a>
                            <div class="navbar-dropdown">
                                <a class="navbar-item" href="{{ route('calendars.index') }}">
                                    Calendars
                                </a>
                                <a class="navbar-item" href="{{ route('calendars.create') }}">
                                    Create New Calendar
                                </a>
                                <hr class="navbar-divider" />
                                <a class="navbar-item" href="{{ route('events.index') }}">
                                    Events
                                </a>
                            </div>
                        </div>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link is-active" href="{{ route('users.index') }}">
                                Users
                            </a>
                            <div class="navbar-dropdown">
                                <a class="navbar-item" href="{{ route('users.create') }}">
                                    Create User
                                </a>
                                <hr class="navbar-divider" />
                                <a class="navbar-item" href="{{ route('users.archived') }}">
                                    Archived Users
                                </a>
                                <hr class="navbar-divider" />
                                <div class="navbar-header">
                                    Groups
                                </div>
                                @foreach (userGroups() as $user_group_menu)
                                    <a class="navbar-item" href="{{ route('user-groups.show', $user_group_menu->slug) }}">
                                        {{ $user_group_menu->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link is-active" href="{{ route('properties.index') }}">
                                Properties
                            </a>
                            <div class="navbar-dropdown">
                                <a class="navbar-item" href="{{ route('properties.create') }}">
                                    Create Property
                                </a>
                                <hr class="navbar-divider" />
                            </div>
                        </div>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link is-active" href="#">
                                Tenancies
                            </a>
                            <div class="navbar-dropdown">
                                <a class="navbar-item" href="#">
                                    Sub Item
                                </a>
                            </div>
                        </div>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link is-active" href="{{ route('invoices.index') }}">
                                Invoices
                            </a>
                            <div class="navbar-dropdown">
                                <a class="navbar-item" href="{{ route('invoices.create') }}">
                                    Create Invoice
                                </a>
                                <hr class="navbar-divider" />
                                <a class="navbar-item" href="{{ route('invoices.unpaid') }}">
                                    Unpaid Invoices
                                </a>
                                <a class="navbar-item" href="{{ route('invoices.overdue') }}">
                                    Overdue Invoices
                                </a>
                                <hr class="navbar-divider" />
                                <div class="navbar-header">
                                    Groups
                                </div>
                                @foreach (invoiceGroups() as $invoice_group_menu)
                                    <a class="navbar-item" href="{{ route('invoice-groups.show', $invoice_group_menu->id) }}">
                                        {{ $invoice_group_menu->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="navbar-end">

                        @if (Auth::check())

                            <div class="navbar-item has-dropdown is-hoverable">
                                <a class="navbar-link is-active" href="{{ route('users.show', Auth::id()) }}">
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="navbar-dropdown">
                                    <a class="navbar-item" href="{{ route('settings.index') }}">
                                        Settings
                                    </a>
                                    <a class="navbar-item" href="{{ route('emails.index') }}">
                                        Sent E-Mails
                                    </a>
                                    <a class="navbar-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form role="form" method="POST" action="{{ route('logout') }}" id="logout-form">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </div>

                        @else

                            <a href="{{ route('login') }}" class="navbar-item">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="navbar-item">
                                Register
                            </a>

                        @endif

                    </div>
                </div>
            </nav>
        </div>

        <div class="container">
            <nav class="breadcrumb">
                <ul>
                    <li><a href="{{ url('/') }}">Home</a></li>
                    @yield('breadcrumbs')
                </ul>
            </nav>
        </div>

        @include('flash::message')

        @yield('content')

    </div>

    <div id="modal-container">
        <div class="modal">
            <div class="modal-background"></div>
            <div id="modal-content"></div>
            <button class="modal-close is-large"></button>
        </div>
    </div>

    <!-- Scripts -->
    <script
      src="https://code.jquery.com/jquery-3.2.1.min.js"
      integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
      crossorigin="anonymous"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    <script src="{{ mix('js/all.js') }}"></script>

    @stack('footer_scripts')
</body>
</html>
