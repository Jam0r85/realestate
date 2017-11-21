@php
	$views = [
		'Active' => 'active',
		'Archived' => 'archived'
	];
@endphp

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

		<div class="row">
			<div class="col-12 col-md-4 col-lg-3 col-xl-2">

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

				<div class="nav flex-column nav-pills mb-5" id="v-pills-tab" role="tablist" aria-orientation="vertical">

					@foreach ($views as $key => $value)
						<a class="nav-link @if (request('section') == str_slug($key)) active @elseif (!request('section') && $loop->first) active @endif" id="v-pills-{{ str_slug($key) }}-tab" data-toggle="pill" href="#v-pills-{{ str_slug($key) }}" role="tab">
							{{ $key }}
						</a>
					@endforeach

				</div>

			</div>
			<div class="col-12 col-md-8 col-lg-9 col-xl-10">

				@component('partials.table')
					@slot('header')
						<th>Name</th>
						<th>Email</th>
						<th>Mobile Phone</th>
						<th>Other Phone</th>
						<th>Location</th>
					@endslot
					@slot('body')
						@foreach ($users as $user)
							<tr>
								<td>
									<a href="{{ route('users.show', $user->id) }}" title="View {{ $user->name }}'s Profile">
										{{ $user->present()->fullName }}
									</a>
								</td>
								<td>{{ $user->email }}</td>
								<td>{{ $user->phone_number }}</td>
								<td>{{ $user->phone_number_other }}</td>
								<td>{{ $user->present()->location }}</td>
							</tr>
						@endforeach
					@endslot
				@endcomponent

				@include('partials.pagination', ['collection' => $users])

			</div>
		</div>

	@endcomponent

@endsection