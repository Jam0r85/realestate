@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">

			<form method="POST" action="{{ route('notifications.clear', $user->id) }}" class="d-inline">
				{{ csrf_field() }}
				<button type="submit" class="btn btn-primary">
					<i class="fa fa-bell"></i> Clear Notifications
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

	@component('partials.section-with-container')

		@foreach ($user->notifications as $notification)

			<div class="card mb-3">
				@component('partials.card-header')
					{{ datetime_formatted($notification->created_at) }}
				@endcomponent

				@include('notifications.users.' . snake_case(class_basename($notification->type)))
			</div>

		@endforeach

	@endcomponent

@endsection