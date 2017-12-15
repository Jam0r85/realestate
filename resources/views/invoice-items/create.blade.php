@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@if (count($invoice->statements))
				@foreach ($invoice->statements as $statement)
					@component('partials.return-button')
						{{ $statement->present()->name }}
						@slot('url')
							{{ route('statements.show', $statement->id) }}
						@endslot
					@endcomponent
				@endforeach
			@endif

			@component('partials.return-button')
				Invoice #{{ $invoice->present()->name }}
				@slot('url')
					{{ route('invoices.show', $invoice->id) }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			Invoice {{ $invoice->number }}
		@endcomponent

		@component('partials.sub-header')
			Create Invoice Item
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-sm-12 col-md-5">

				<div class="card mb-3">

					@component('partials.card-header')
						Invoice Item Details
					@endcomponent

					<div class="card-body">

						@if ($invoice->isPaid())

							@component('partials.alerts.warning')
								This invoice has been paid and cannot accept new items.
							@endcomponent

						@else

							<form method="POST" action="{{ route('invoice-items.store', $invoice->id) }}">
								{{ csrf_field() }}

								@include('invoice-items.partials.form')

								@component('partials.save-button')
									Add Invoice Item
								@endcomponent

							</form>

						@endif

					</div>
				</div>

			</div>
			<div class="col-sm-12 col-md-7">

				<div class="card mb-3">

					@component('partials.card-header')
						Current Invoice Items
					@endcomponent

					@include('invoice-items.partials.items-table', ['items' => $invoice->items])
					
				</div>

			</div>
		</div>

	@endcomponent

@endsection