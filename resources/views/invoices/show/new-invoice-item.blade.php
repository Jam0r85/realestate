@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-secondary float-right">
				Return
			</a>

			@component('partials.header')
				Invoice #{{ $invoice->number }}
			@endcomponent

			@component('partials.sub-header')
				Add a new item
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		<div class="row">
			<div class="col-sm-12 col-md-5">

				@include('partials.errors-block')

				<div class="card mb-3">

					@component('partials.card-header')
						Invoice Item Details
					@endcomponent

					<div class="card-body">

						<form method="POST" action="{{ route('invoices.create-item', $invoice->id) }}">
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

					<table class="table table-striped table-hover table-responsive">
						<thead>
							<th>Name</th>
							<th>Amount</th>
							<th>#</th>
							<th class="text-right">Total</th>
						</thead>
						<tbody>
							@foreach ($invoice->items as $item)
								<tr>
									<td>
										<a href="{{ route('invoices.edit-item', $item->id) }}" name="Edit Item">
											{{ $item->name }}
										</a>
									</td>
									<td>{{ currency($item->amount) }}</td>
									<td>{{ $item->quantity }}</td>
									<td class="text-right">{{ currency($item->total) }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>

			</div>
		</div>

	@endcomponent

@endsection