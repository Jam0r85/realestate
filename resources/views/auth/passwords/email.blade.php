@extends('layouts.app')

@section('content')

    @component('partials.sections.section')

        <div class="columns">
            <div class="column is-half is-offset-one-quarter">

                @if (session('status'))
                    @component('partials.notifications.success')
                        {{ session('status') }}
                    @endcomponent
                @endif

                @include('partials.errors-block')

                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            Request Password Reset
                        </p>
                    </header>
                    <div class="card-content">

                        <form role="form" method="POST" action="{{ route('password.email') }}">
                            {{ csrf_field() }}

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

                            <a href="{{ route('login') }}" class="is-pulled-right button is-link">
                                Back to Login
                            </a>

                            @component('partials.forms.buttons.save')
                                Send Password Reset Link
                            @endcomponent

                        </form>

                    </div>
                </div>

            </div>
        </div>

    @endcomponent

@endsection