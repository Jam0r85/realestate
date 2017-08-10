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
     <link href="{{ mix('css/all.css') }}" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">

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

                @auth()
                    <div class="navbar-start">
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link is-active" href="#">
                                Planner
                            </a>
                            <div class="navbar-dropdown">
                                <a class="navbar-item" href="{{ route('calendars.index') }}">
                                    Calendars
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
                                    New User
                                </a>
                                <hr class="navbar-divider" />
                                <a class="navbar-item" href="{{ route('users.archived') }}">
                                    Archived Users
                                </a>
                                <hr class="navbar-divider" />
                                <div class="navbar-header">
                                    Bank Accounts
                                </div>
                                <a class="navbar-item" href="{{ route('bank-accounts.index') }}">
                                    Bank Account List
                                </a>
                                <a class="navbar-item" href="{{ route('bank-accounts.create') }}">
                                    New Bank Account
                                </a>
                            </div>
                        </div>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link is-active" href="{{ route('properties.index') }}">
                                Properties
                            </a>
                            <div class="navbar-dropdown">
                                <a class="navbar-item" href="{{ route('properties.create') }}">
                                    New Property
                                </a>
                                <hr class="navbar-divider" />
                                <div class="navbar-header">
                                    Expenses
                                </div>
                                <a class="navbar-item" href="{{ route('expenses.paid') }}">
                                    Paid Expenses
                                </a>
                                <a class="navbar-item" href="{{ route('expenses.unpaid') }}">
                                    Unapid Expenses
                                </a>
                            </div>
                        </div>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link is-active" href="{{ route('tenancies.index') }}">
                                Tenancies
                            </a>
                            <div class="navbar-dropdown">
                                <a class="navbar-item" href="{{ route('tenancies.create') }}">
                                    New Tenancy
                                </a>
                                <hr class="navbar-divider" />
                                <a class="navbar-item" href="{{ route('tenancies.overdue') }}">
                                    Overdue
                                </a>
                                <hr class="navbar-divider" />
                                <div class="navbar-header">
                                    Payments
                                </div>
                                <a class="navbar-item" href="{{ route('payments.rent') }}">
                                    Rent Payments
                                </a>
                                <hr class="navbar-divider" />
                                <div class="navbar-header">
                                    Statements
                                </div>
                                <a class="navbar-item" href="{{ route('statements.index') }}">
                                    Sent Statements
                                </a>
                                <a class="navbar-item" href="{{ route('statements.unsent') }}">
                                    Unsent Statements
                                </a>
                                <a class="navbar-item" href="{{ route('statements.unpaid') }}">
                                    Unpaid Statements
                                </a>
                                <hr class="navbar-divider" />
                                <div class="navbar-header">
                                    Statement Payments
                                </div>
                                <a class="navbar-item" href="{{ route('statement-payments.index') }}">
                                    Sent Payments
                                </a>
                                <a class="navbar-item" href="{{ route('statement-payments.unsent') }}">
                                    Unsent Payments
                                </a>
                            </div>
                        </div>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link is-active" href="{{ route('invoices.index') }}">
                                Invoices
                            </a>
                            <div class="navbar-dropdown">
                                <a class="navbar-item" href="{{ route('invoices.create') }}">
                                    New Invoice
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
                    @endauth

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
            
        @include('flash::message')

        {{-- Show a warning if no branches have been created --}}
        @if (!count(branches()))
            <div class="notification">
                No branches have been registered with this application. Please register a branch in the <a href="{{ route('settings.branches') }}">Settings</a>.
            </div>
        @endif

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
