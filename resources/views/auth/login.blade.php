@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-6 ml-auto mr-auto">

                <div class="card">
                    <div class="card-header">
                        Staff Login
                    </div>
                    <div class="card-body">

                        @include('partials.errors-block')

                        <form role="form" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="email">E-Mail Address</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" />
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" name="remember_me" value="true" class="custom-control-input">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Remember me?</span>
                                </label>
                            </div>

                            <div class="float-right">
                                <a href="{{ route('password.request') }}" class="btn btn-light">
                                    Forgotten Password?
                                </a>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Login
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
    
@endsection
