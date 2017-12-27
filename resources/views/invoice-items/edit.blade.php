@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">

			@if (count($item->invoice->statements))
				@foreach ($item->invoice->statements as $statement)
					@component('partials.return-button')
						{{ $statement->present()->name }}
						@slot('url')
							{{ route('statements.show', $statement->id) }}
						@endslot
					@endcomponent
				@endforeach
			@endif

			@component('partials.return-button')
				{{ $item->invoice->present()->name }}
				@slot('url')
					{{ route('invoices.show', $item->invoice->id) }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			Invoice #{{ $item->invoice->number }}
		@endcomponent

		@component('partials.sub-header')
			Edit invoice item
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-6">

				<div class="card mb-3">

					@component('partials.card-header')
						Item Details
					@endcomponent

					<div class="card-body">

						<form method="POST" action="{{ route('invoice-items.update', $item->id) }}">
							{{ csrf_field() }}
							{{ method_field('PUT') }}

							@include('invoice-items.partials.form')

							@component('partials.save-button')
								Save Changes
							@endcomponent

						</form>

					</div>
				</div>

			</div>
			<div class="col-12 col-lg-6">

				<div class="card mb-3">
					@component('partials.card-header')
						Delete Invoice Item
					@endcomponent
					<div class="card-body">

						<form method="POST" action="{{ route('invoice-items.destroy', $item->id) }}">
							{{ csrf_field() }}
							{{ method_field('DELETE') }}

							@component('partials.save-button')
								Delete Invoice Item
							@endcomponent

						</form>

					</div>
				</div>

			</div>
		</div>

	@endcomponent

@endsection