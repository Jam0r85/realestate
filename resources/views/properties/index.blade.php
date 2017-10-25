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

		<table class="table table-striped table-hover table-responsive">
			<thead>
				<th>Name</th>
				<th></th>
				<th class="text-right">Owners</th>
			</thead>
			<tbody>
				@foreach ($properties as $property)
					<tr>
						<td>
							<a href="{{ route('properties.show', $property->id) }}">
								{{ $property->name }}
							</a>
						</td>
						<td>
							@if ($property->trashed())
								<span class="text-muted"><i class="fa fa-archive"></i> Archived</span>
							@endif
						</td>
						<td class="text-right">
							@include('partials.bootstrap.users-inline', ['users' => $property->owners])
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>

		@include('partials.pagination', ['collection' => $properties])

	@endcomponent

@endsection