@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">

			{{-- Return back to the Expense --}}
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

		@component('partials.sub-header')
			{{ $document->path }}
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

				<form method="POST" action="{{ route('documents.update', $document->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					@component('partials.card')
						@slot('header')
							Document Details
						@endslot

						<div class="card-body">

							@component('partials.form-group')
								@slot('name')
									File Name
								@endslot
								<input type="text" name="name" id="name" class="form-control" value="{{ $document->name }}" />
							@endcomponent

						</div>

						@slot('footer')
							@component('partials.save-button')
								Save Changes
							@endcomponent
						@endslot
					@endcomponent

				</form>

				<form method="POST" action="{{ route('documents.upload', $document->id) }}" enctype="multipart/form-data">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					@component('partials.card')
						@slot('header')
							@icon('upload') Re-Upload Document
						@endslot

						<div class="card-body">

							@component('partials.alerts.warning')
								This will replace the existing file with a new one.
							@endcomponent

							@component('partials.form-group')
								@slot('name')
									Select file..
								@endslot
								<input type="file" name="file" id="file" class="form-control" />
							@endcomponent

						</div>

						@slot('footer')
							@component('partials.save-button')
								Upload File
							@endcomponent
						@endslot
					@endcomponent

				</form>

			</div>
			<div class="col-12 col-lg-6">

				@if ($document->deleted_at)

					<form method="POST" action="{{ route('documents.restore', $document->id) }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}

						@component('partials.card')
							@slot('header')
								@icon('restore') Restore Document
							@endslot
							@slot('footer')
								@component('partials.save-button')
									Restore Document
								@endcomponent
							@endslot
						@endcomponent

					</form>

					<form method="POST" action="{{ route('documents.forceDestroy', $document->id) }}">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}

						@component('partials.card')
							@slot('header')
								@icon('destroy') Destroy Document
							@endslot
							@slot('footer')
								@component('partials.save-button')
									Destroy Document
								@endcomponent
							@endslot
						@endcomponent

					</form>

				@else

					<form method="POST" action="{{ route('documents.destroy', $document->id) }}">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}

						@component('partials.card')
							@slot('header')
								@icon('delete') Delete Document
							@endslot
							@slot('footer')
								@component('partials.save-button')
									Delete Document
								@endcomponent
							@endslot
						@endcomponent

					</form>

				@endif

			</div>
		</div>

	@endcomponent

@endsection