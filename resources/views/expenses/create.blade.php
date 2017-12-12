@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			Create Expense
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<div class="card mb-3">
			@component('partials.card-header')
				Create Expense
			@endcomponent

			<div class="card-body">

				<form method="POST" action="{{ route('expenses.store') }}" enctype="multipart/form-data">
					{{ csrf_field() }}

					@include('expenses.partials.form')

					<div class="form-group">
						<label for="files">Upload Invoice(s)</label>
						<input type="file" id="files" class="form-control-file" name="files[]" multiple />
					</div>

					@component('partials.save-button')
						Create Expense
					@endcomponent

				</form>

			</div>
		</div>

	@endcomponent

@endsection