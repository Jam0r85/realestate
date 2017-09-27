@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>
					{{ $title }}
					<a href="{{ route('users.create') }}" class="btn btn-primary">
						<i class="fa fa-user-plus"></i> New User
					</a>
				</h1>
			</div>

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

		</div>
	</section>

	<section class="section">
		<div class="container">

			@include('users.partials.table', $users)

		</div>
	</section>

@endsection