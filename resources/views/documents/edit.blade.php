@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@if (model_name($document->parent) == 'Expense')
				@component('partials.return-button')
					Expense #{{ $document->parent_id }}
					@slot('url')
						{{ route('expenses.show', $document->parent_id) }}
					@endslot
				@endcomponent
			@endif

			@component('partials.return-button')
				Return
				@slot('url')
					{{ route('documents.show', $document->id) }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			Document #{{ $document->id }}
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		@if (!Storage::exists($document->path))
			@component('partials.alerts.warning')
				The file cannot be located for this document. Please either delete this document or re-upload it using the form below.
			@endcomponent
		@endif

		<div class="row">
			<div class="col-12 col-lg-6">

				<div class="card mb-3">
					@component('partials.card-header')
						Document Details
					@endcomponent
					<div class="card-body">

						<form method="POST" action="{{ route('documents.update', $document->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}

							@component('partials.form-group')
								@slot('name')
									File Name
								@endslot
								<input type="text" name="name" id="name" class="form-control" value="{{ $document->name }}" />
							@endcomponent

							@component('partials.save-button')
								Save Changes
							@endcomponent

						</form>

					</div>
				</div>

			</div>
			<div class="col-12 col-lg-6">

				@if ($document->deleted_at)

					<div class="card mb-3">
						@component('partials.card-header')
							Restore Document
						@endcomponent
						<div class="card-body">

							<form method="POST" action="{{ route('documents.restore', $document->id) }}">
								{{ csrf_field() }}
								{{ method_field('PUT') }}

								@component('partials.save-button')
									Restore Document
								@endcomponent

							</form>

						</div>
					</div>

					<div class="card mb-3">
						@component('partials.card-header')
							Destroy Document
						@endcomponent
						<div class="card-body">

							<form method="POST" action="{{ route('documents.forceDestroy', $document->id) }}">
								{{ csrf_field() }}
								{{ method_field('DELETE') }}

								@component('partials.save-button')
									Destroy Document
								@endcomponent

							</form>

						</div>
					</div>

				@else

					<div class="card mb-3">
						@component('partials.card-header')
							Delete Document
						@endcomponent
						<div class="card-body">

							<form method="POST" action="{{ route('documents.destroy', $document->id) }}">
								{{ csrf_field() }}
								{{ method_field('DELETE') }}

								@component('partials.save-button')
									Delete Document
								@endcomponent

							</form>

						</div>
					</div>

				@endif

			</div>
		</div>

	@endcomponent

@endsection