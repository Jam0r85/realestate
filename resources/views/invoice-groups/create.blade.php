@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			New Invoice Group
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<div class="card mb-3">
			@component('partials.card-header')
				Group Details
			@endcomponent

			<div class="card-body">

				<form method="POST" action="{{ route('invoice-groups.store') }}">
					{{ csrf_field() }}

					<div class="form-group">
						<label for="branch_id">Branch</label>
						<select class="form-control" name="branch_id">
							@foreach(branches() as $branch)
								<option value="{{ $branch->id }}">{{ $branch->name }}</option>
							@endforeach
						</select>
					</div>

					@include('invoice-groups.partials.form')

					@component('partials.save-button')
						Create Group
					@endcomponent

				</form>

			</div>
		</div>

	@endcomponent

@endsection