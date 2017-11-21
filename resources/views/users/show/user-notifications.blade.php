@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">

			<form method="POST" action="{{ route('users.clear-notifications', $user->id) }}" class="d-inline">
				{{ csrf_field() }}
				<button type="submit" class="btn btn-primary">
					<i class="fa fa-bell"></i> Clear All Notifications
				</button>
			</form>

			@component('partials.return-button')
				@slot('url')
					{{ route('users.show', $user->id) }}
				@endslot
			@endcomponent

		</div>

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
				@component('partials.card-header')
					{{ datetime_formatted($notification->created_at) }}
				@endcomponent

				@include('users.notifications.' . snake_case(class_basename($notification->type)))
			</div>

		@endforeach

	@endcomponent

@endsection