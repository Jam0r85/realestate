@extends('layouts.app')

@section('content')

    @component('partials.sections.section')

        <div class="columns">
            <div class="column is-half is-offset-one-quarter">

                @include('partials.errors-block')

                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            Register
                        </p>
                    </header>
                    <div class="card-content">

                        <form role="form" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}

                            @component('partials.forms.field')
                                @slot('label')
                                    Name
                                @endslot
                                @slot('name')
                                    name
                                @endslot
                                @slot('iconLeft')
                                    user
                                @endslot
                            @endcomponent

                            @component('partials.forms.field')
                                @slot('label')
                                    E-Mail Address
                                @endslot
                                @slot('name')
                                    email
                                @endslot
                                @slot('iconLeft')
                                    envelope
                                @endslot
                            @endcomponent

                            @component('partials.forms.field')
                                @slot('type')
                                    password
                                @endslot
                                @slot('label')
                                    Password
                                @endslot
                                @slot('name')
                                    password
                                @endslot
                                @slot('iconLeft')
                                    lock
                                @endslot
                            @endcomponent

                            @component('partials.forms.field')
                                @slot('type')
                                    password
                                @endslot
                                @slot('label')
                                    Confirm Password
                                @endslot
                                @slot('name')
                                    password_confirmation
                                @endslot
                                @slot('iconLeft')
                                    lock
                                @endslot
                            @endcomponent

                            <a href="{{ route('login') }}" class="is-pulled-right button is-link">
                                Back to Login
                            </a>

                            @component('partials.forms.buttons.save')
                                Register
                            @endcomponent

                        </form>

                    </div>
                </div>

            </div>
        </div>

    @endcomponent

@endsection
