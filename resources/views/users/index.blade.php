@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('users.create') }}" class="btn btn-primary float-right">
			<i class="fa fa-user-plus"></i> Register User
		</a>

		@component('partials.header')
			{{ $title }}
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		{{-- Users Search --}}
		@component('partials.bootstrap.page-search')
			@slot('route')
				{{ route('users.search') }}
			@endslot
			@if (session('users_search_term'))
				@slot('search_term')
					{{ session('users_search_term') }}
				@endslot
			@endif
		@endcomponent
		{{-- End of Users Search --}}

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@component('partials.table')
			@slot('header')
				<th>Name</th>
				<th>Email</th>
				<th>Mobile Phone</th>
				<th>Other Phone</th>
			@endslot
			@slot('body')
				@foreach ($users as $user)
					<tr>
						<td>
							<a href="{{ route('users.show', $user->id) }}" title="View {{ $user->name }}'s Profile">
								{{ $user->name }}
							</a>
						</td>
						<td>{{ $user->email }}</td>
						<td>{{ $user->phone_number }}</td>
						<td>{{ $user->phone_number_other }}</td>
					</tr>
				@endforeach
			@endslot
		@endcomponent

		@include('partials.pagination', ['collection' => $users])

	@endcomponent

@endsection