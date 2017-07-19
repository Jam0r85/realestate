@extends('layouts.app')

@section('content')

    @component('partials.sections.section')

        <div class="columns">
            <div class="column is-half is-offset-one-quarter">

                @include('partials.errors-block')

                <div class="card">
                    <header class="card-header">
                        <p class="card-header-title">
                            Staff Login
                        </p>
                    </header>
                    <div class="card-content">

                        <form role="form" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                            <div class="field">
                                <label class="label" for="email">E-Mail Address</label>
                                <p class="control">
                                    <input type="email" name="email" class="input" value="{{ old('email') }}" />
                                </p>
                            </div>

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
                            @endcomponent

                            @component('partials.forms.field-checkbox')
                                @slot('label')
                                    Remember Me?
                                @endslot
                                @slot('name')
                                    remember_me
                                @endslot
                                @slot('value')
                                    true
                                @endslot
                            @endcomponent

                            <a href="{{ route('password.request') }}" class="is-pulled-right button is-link">
                                Forgotten Password?
                            </a>

                            @component('partials.forms.buttons.save')
                                Login
                            @endcomponent

                        </form>

                    </div>
                </div>

            </div>
        </div>

    @endcomponent
    
@endsection
