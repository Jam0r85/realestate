@extends('layouts.app')

@section('content')

    <div class="container mt-5">

        <div class="row">
            <div class="col-sm-12 col-lg-6 ml-lg-auto mr-lg-auto">

                @if (get_setting('company_logo'))
                    <div class="row mb-5">
                        <div class="col-sm-12 col-lg-6 ml-lg-auto mr-lg-auto">
                            <img src="{{ get_file(get_setting('company_logo')) }}" class="img-fluid" />
                        </div>
                    </div>
                @endif

                <form role="form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    @component('partials.card')
                        @slot('header')
                            Staff Login
                        @endslot

                        @slot('body')

                        @include('partials.errors-block')

                            @component('partials.form-group')
                                @slot('label')
                                    E-Mail
                                @endslot
                                @component('partials.input-group')
                                    @slot('icon')
                                        @icon('email')
                                    @endslot
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required />
                                @endcomponent
                            @endcomponent

                            @component('partials.form-group')
                                @slot('label')
                                    Password
                                @endslot
                                @component('partials.input-group')
                                    @slot('icon')
                                        @icon('password')
                                    @endslot
                                    <input type="password" name="password" id="password" class="form-control" required />
                                @endcomponent
                            @endcomponent

                            @component('partials.form-group')
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="true" name="remember_me" id="remember_me">
                                    <label class="form-check-label" for="remember_me">
                                        Remember me?
                                    </label>
                                </div>
                            @endcomponent

                        @endslot

                        @slot('footer')

                            <div class="float-right">
                                <a href="{{ route('password.request') }}" class="btn btn-secondary">
                                    Forgotten Password?
                                </a>
                            </div>

                            @include('partials.forms.login-button')
                        @endslot

                    @endcomponent

                </form>

            </div>
        </div>
    </div>
    
@endsection
