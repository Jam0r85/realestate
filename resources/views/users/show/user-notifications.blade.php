@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('users.show', $user->id) }}" class="btn btn-secondary float-right">
			Return
		</a>

		@component('partials.header')
			{{ $user->present()->fullName }}
		@endcomponent

		@component('partials.sub-header')
			My Notifications
		@endcomponent

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