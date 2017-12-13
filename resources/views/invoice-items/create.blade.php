@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			@component('partials.return-button')
				@slot('url')
					@if ($invoice->statement)
						{{ route('statements.show', $invoice->statement->id) }}
					@else
						{{ route('invoices.show', $invoice->id) }}
					@endif
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			Invoice #{{ $invoice->number }}
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

						<form method="POST" action="{{ route('invoice-items.store', $invoice->id) }}">
							{{ csrf_field() }}

							@include('invoices.partials.item-form')

							@component('partials.save-button')
								Add Invoice Item
							@endcomponent

						</form>

					</div>
				</div>

			</div>
			<div class="col-sm-12 col-md-7">

				<div class="card mb-3">

					@component('partials.card-header')
						Current Invoice Items
					@endcomponent

					@component('partials.table')
						@slot('header')
							<th>Name</th>
							<th>Amount</th>
							<th>#</th>
							<th class="text-right">Total</th>
						@endslot
						@slot('body')
							@foreach ($invoice->items as $item)
								<tr>
									<td>
										<a href="{{ route('invoice-items.edit', $item->id) }}" name="Edit Item">
											{{ $item->name }}
										</a>
									</td>
									<td>{{ currency($item->amount) }}</td>
									<td>{{ $item->quantity }}</td>
									<td class="text-right">{{ currency($item->total) }}</td>
								</tr>
							@endforeach
						@endslot
					@endcomponent
					
				</div>

			</div>
		</div>

	@endcomponent

@endsection