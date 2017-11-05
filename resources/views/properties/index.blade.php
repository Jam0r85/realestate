@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<a href="{{ route('properties.create') }}" class="btn btn-primary float-right">
				<i class="fa fa-plus"></i> New Property
			</a>

			@component('partials.header')
				{{ $title }}
			@endcomponent

		</div>

		{{-- Properties Search --}}
		@component('partials.bootstrap.page-search')
			@slot('route')
				{{ route('properties.search') }}
			@endslot
			@if (session('properties_search_term'))
				@slot('search_term')
					{{ session('properties_search_term') }}
				@endslot
			@endif
		@endcomponent
		{{-- End of Properties Search --}}

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@component('partials.table')
			@slot('header')
				<th>Name</th>
				<th class="text-right">Owners</th>
			@endslot
			@slot('body')
				@foreach ($properties as $property)
					<tr>
						<td>
							<a href="{{ route('properties.show', $property->id) }}">
								{{ $property->name }}
							</a>
						</td>
						<td class="text-right">
							@include('partials.bootstrap.users-inline', ['users' => $property->owners])
						</td>
					</tr>
				@endforeach
			@endslot
		@endcomponent

		@include('partials.pagination', ['collection' => $properties])

	@endcomponent

@endsection