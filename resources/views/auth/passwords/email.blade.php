@extends('layouts.app')

@section('content')

    <section class="section">
        <div class="container">

            <div class="row">
                <div class="col-md-6 mr-auto ml-auto">

                    @if (session('status'))
                        <div class="alert alert-info">
                            {{ session('status') }}
                        </div>
                    @endif

                    @include('partials.errors-block')

                    <div class="card">
                        <div class="card-header">
                            Request Password Reqest
                        </div>
                        <div class="card-body">

                            <form role="form" method="POST" action="{{ route('password.email') }}">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <label for="email">E-Mail Address</label>
                                    <input type="email" name="email" class="form-control" />
                                </div>

                                <a href="{{ route('login') }}" class="float-right btn btn-link">
                                    Back to Login
                                </a>
                                
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
                                </button>

                            </form>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

@endsection