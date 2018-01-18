<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

    <a class="navbar-brand" href="{{ route('dashboard') }}">
        {{ get_setting('company_name', config('app.name')) }}
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle Navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarMain">
        <ul class="navbar-nav mr-auto">

            @auth

                <!-- Planner -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarPlannerDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @icon('calendar') @lang('navbar.planner')
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarPlannerDropdown">
                        <a class="dropdown-item" href="{{ route('calendars.index') }}">
                            @icon('calendar') @lang('navbar.calendars')
                        </a>
                        <a class="dropdown-item" href="{{ route('events.index') }}">
                            @icon('events') @lang('navbar.events')
                        </a>
                    </div>
                </li>
                <!-- End Planner -->

                <!-- Users -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarUsersDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @icon('users') @lang('navbar.users')
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarUsersDropdown">
                        <a class="dropdown-item" href="{{ route('users.index') }}">
                            @icon('users') @lang('navbar.users')
                        </a>
                        <a class="dropdown-item" href="{{ route('user-logins.index') }}">
                            @icon('history') @lang('navbar.users_login_history')
                        </a>
                        <a class="dropdown-item" href="{{ route('bank-accounts.index') }}">
                            @icon('bank') @lang('navbar.bank_accounts')
                        </a>
                    </div>
                </li>
                <!-- End Users -->

                <!-- Properties -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarPropertiesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @icon('house') @lang('navbar.properties')
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarPropertiesDropdown">
                        <a class="dropdown-item" href="{{ route('valuations.index') }}">
                            @icon('valuation') @lang('navbar.valuations')
                        </a>
                        <a class="dropdown-item" href="{{ route('properties.index') }}">
                            @icon('house') @lang('navbar.properties')
                        </a>
                        <a class="dropdown-item" href="{{ route('appearances.index') }}">
                            @icon('appearance') @lang('navbar.appearances')
                        </a>
                        <a class="dropdown-item" href="{{ route('expenses.index') }}">
                           @icon('money') @lang('navbar.expenses')
                        </a>
                    </div>
                </li>
                <!-- End Properties -->

                <!-- Payments -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('payments.index') }}">
                        @icon('payment') @lang('navbar.payments')
                    </a>
                </li>
                <!-- End Payments -->

                <!-- Documents -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('documents.index') }}">
                        @icon('document') @lang('navbar.documents')
                    </a>
                </li>
                <!-- End Documents -->

                <!-- Tenancies -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarTenanciesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @icon('tenancy') @lang('navbar.tenancies')
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarTenanciesDropdown">
                        <a class="dropdown-item" href="{{ route('tenancies.index') }}">
                            @icon('tenancy') @lang('navbar.tenancies')
                        </a>
                        <a class="dropdown-item" href="{{ route('maintenances.index') }}">
                            @icon('maintenance') @lang('navbar.maintenance')
                        </a>
                        <a class="dropdown-item" href="{{ route('statements.index') }}">
                            @icon('statement') @lang('navbar.statements')
                        </a>
                        <a class="dropdown-item" href="{{ route('statement-payments.index') }}">
                            @icon('payment') @lang('navbar.statement_payments')
                        </a>
                        <a class="dropdown-item" href="{{ route('deposits.index') }}">
                            @icon('deposit') @lang('navbar.deposits')
                        </a>
                        <a class="dropdown-item" href="{{ route('agreements.index') }}">
                            @icon('agreement') @lang('navbar.agreements')
                        </a>
                        <a class="dropdown-item" href="{{ route('services.index') }}">
                            @icon('tenancy_service') @lang('navbar.tenancy_services')
                        </a>
                        <div class="dropdown-divider"></div>
                        <h6 class="dropdown-header">Management</h6>
                        <a class="dropdown-item" href="{{ route('gas-safe.index') }}">
                            Gas Inspections
                        </a>
                        <a class="dropdown-item" href="{{ route('gas-safe.archived') }}">
                            Completed Gas Inspections
                        </a>
                    </div>
                </li>
                <!-- End Tenancies -->

                <!-- Invoices -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarInvoicesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @icon('invoice') @lang('navbar.invoices')
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarInvoicesDropdown">
                        <a class="dropdown-item" href="{{ route('invoices.index') }}">
                            @icon('invoice') @lang('navbar.invoices')
                        </a>
                        <a class="dropdown-item" href="{{ route('invoice-groups.index') }}">
                            @icon('invoice_group') @lang('navbar.invoice_groups')
                        </a>
                    </div>
                </li>
                <!-- End Invoices -->

            @endauth

        </ul>
        <ul class="navbar-nav">

            @auth

                <!-- Notifications -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.show', [Auth::user()->id, 'notifications']) }}">
                        @icon('bell') Notifications
                    </a>
                </li>
                <!-- End Notifications -->

                <!-- Profile -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarProfileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="{{ Auth::user()->isSuperAdmin() ? 'text-danger' : '' }}">
                            @icon('user') {{ Auth::user()->present()->fullName }}
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarProfileDropdown">
                        @if (count(Auth::user()->staffBranches))
                            <h5 class="dropdown-header">
                                Branches
                            </h5>
                            @foreach (Auth::user()->staffBranches as $branch)
                                <a class="dropdown-item" href="{{ route('branches.show', $branch->id) }}">
                                    @icon('branch') {{ $branch->name }}
                                </a>
                            @endforeach
                            <div class="dropdown-divider"></div>
                        @endif
                        <a class="dropdown-item" href="{{ route('users.show', Auth::user()->id) }}">
                            @icon('user') @lang('navbar.profile')
                        </a>
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            @icon('logout') @lang('navbar.logout')
                        </a>
                        <form role="form" method="POST" action="{{ route('logout') }}" id="logout-form">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
                <!-- End Profile -->

                <!-- Options -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarOptionsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @icon('options') @lang('navbar.options')
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarOptionsDropdown">
                        <a class="dropdown-item" href="{{ route('settings.index') }}">
                            @icon('settings') @lang('navbar.settings')
                        </a>
                        <a class="dropdown-item" href="{{ route('branches.index') }}">
                            @icon('branch') @lang('navbar.branches')
                        </a>
                        <a class="dropdown-item" href="{{ route('permissions.index') }}">
                            @icon('permissions') @lang('navbar.permissions')
                        </a>
                        <a class="dropdown-item" href="{{ route('reports.index') }}">
                            @icon('report') @lang('navbar.reports')
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('emails.index') }}">
                            @icon('email') @lang('navbar.email_history')
                        </a>
                        <a class="dropdown-item" href="{{ route('sms.index') }}">
                            @icon('sms') @lang('navbar.sms_history')
                        </a>
                    </div>
                </li>
                <!-- End Options -->

            @endauth

            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">
                        @icon('sign-in') Login
                    </a>
                </li>
                @if (!count(users()))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            Register
                        </a>
                    </li>
                @endif
            @endguest

        </ul>
    </div>
</nav>