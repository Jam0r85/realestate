@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<a href="{{ route('users.show', $user->id) }}" class="btn btn-secondary float-right">
				Return
			</a>

			@component('partials.header')
				{{ $user->name }}
			@endcomponent

			@component('partials.sub-header')
				My Notifications
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@foreach ($user->notifications as $notification)

			<div class="card mb-3">
				<div class="card-body">

				</div>
			</div>

		@endforeach

	@endcomponent

@endsection