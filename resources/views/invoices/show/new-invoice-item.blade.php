@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-secondary float-right">
					Return
				</a>
				<h1>Invoice #{{ $invoice->number }}</h1>
				<h3>Add a new item</h3>
			</div>

		</div>
	</section>

	<section class="section">
		<div class="container">

			@if ($invoice->statement)

				<div class="alert alert-warning">
					This invoice is attached to a Rental Statement. Invoice items will be added to the statement automatically when created.
				</div>

			@endif

			<div class="row">
				<div class="col-sm-12 col-md-6">

					@include('partials.errors-block')

					<div class="card mb-3 border-primary">
						<div class="card-header bg-primary text-white">
							Item Details
						</div>
						<div class="card-body">

							<form role="form" method="POST" action="{{ route('invoices.create-item', $invoice->id) }}">
								{{ csrf_field() }}

								@include('invoices.partials.item-form')

								@component('partials.bootstrap.save-submit-button')
									Add Invoice Item
								@endcomponent

							</form>

						</div>
					</div>

				</div>
				<div class="col-sm-12 col-md-6">

					@if (count($invoice->items))

						<div class="card mb-3">
							<div class="card-header">
								Current Invoice Items
							</div>	
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

					@else

						<div class="alert alert-info">
							No items have been added to this invoice yet.
						</div>

					@endif

				</div>
			</div>

		</div>
	</section>

@endsection