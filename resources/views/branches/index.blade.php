@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<a href="{{ route('branches.create') }}" class="btn btn-primary float-right">
			@icon('plus') Register Branch
		</a>

		@component('partials.header')
			Branches
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@component('partials.table')
			@slot('header')
				<th>Name</th>
			@endslot
			@slot('body')
				@foreach ($branches as $branch)
					<tr>
						<td>
							<a href="{{ route('branches.show', $branch->id) }}" title="{{ $branch->name }}">
								{{ $branch->name }}
							</a>
						</td>
					</tr>
				@endforeach
			@endslot
		@endcomponent

	@endcomponent

@endsection