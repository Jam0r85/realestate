@extends('layouts.app')

@section('content')

    @component('partials.page-header')

        @component('partials.header')
            Register
        @endcomponent

    @endcomponent
    
    @component('partials.section-with-container')

        <div class="row">
            <div class="col-12 col-lg-4">

                @include('partials.errors-block')

                <form role="form" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}

                    @component('partials.card')
                        @slot('body')

                            @component('partials.form-group')
                                @slot('label')
                                    First Name
                                @endslot
                                <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}" />
                            @endcomponent

                            @component('partials.form-group')
                                @slot('label')
                                    Last Name
                                @endslot
                                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}" />
                            @endcomponent

                            @component('partials.form-group')
                                @slot('label')
                                    E-Mail Address
                                @endslot
                                <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}" />
                            @endcomponent

                            @component('partials.form-group')
                                @slot('label')
                                    Password
                                @endslot
                                <input type="password" name="password" id="password" class="form-control" required />
                            @endcomponent

                            @component('partials.form-group')
                                @slot('label')
                                    Confirm Password
                                @endslot
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required />
                            @endcomponent

                        @endslot

                        @slot('footer')
                            @component('partials.save-button')
                                Register
                            @endcomponent
                        @endslot

                    @endcomponent

                </form>

            </div>
        </div>

    @endcomponent

@endsection
