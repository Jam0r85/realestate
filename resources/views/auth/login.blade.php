@extends('layouts.app')

@section('content')

    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-12 col-lg-6 ml-lg-auto mr-lg-auto">

                @if (get_setting('company_logo'))
                    <div class="row mb-5">
                        <div class="col-sm-12 col-lg-6 ml-lg-auto mr-lg-auto">
                            <img src="{{ Storage::url(get_setting('company_logo')) }}" class="img-fluid" />
                        </div>
                    </div>
                @endif

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

                <ul class="list-inline small text-muted mt-3">
                    <li class="list-inline-item"><b>Staff:</b></li>
                    @foreach (staff() as $user)
                        <li class="list-inline-item">{{ $user->present()->fullName }}</li>
                    @endforeach
                </ul>

            </div>
        </div>
    </div>
    
@endsection
