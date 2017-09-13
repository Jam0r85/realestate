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

			<div class="row">
				<div class="col-5">

					@include('partials.errors-block')

					<form role="form" method="POST" action="{{ route('invoices.create-item', $invoice->id) }}">
						{{ csrf_field() }}

						@include('invoices.partials.item-form')

						@component('partials.bootstrap.save-submit-button')
							Add Invoice Item
						@endcomponent

					</form>

				</div>
				<div class="col">

					@if (count($invoice->items))
						<div class="card mb-3">
							<div class="card-header">
								Current Invoice Items
							</div>							
							<table class="table table-striped table-responsive">
								<thead>
									<th>Name</th>
									<th>Amount</th>
									<th>Quantity</th>
									<th>Total</th>
								</thead>
								<tbody>
									@foreach ($invoice->items as $item)
										<tr>
											<td>{{ $item->name }}</td>
											<td>{{ currency($item->amount) }}</td>
											<td>{{ $item->quantity }}</td>
											<td>{{ currency($item->total) }}</td>
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