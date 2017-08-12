@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('invoices.show', $invoice->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">Invoice #{{ $invoice->number }}</h1>
			<h2 class="subtitle">Add a new item</h2>

			<hr />

			<div class="columns">
				<div class="column is-6">

					<form role="form" method="POST" action="{{ route('invoices.create-item', $invoice->id) }}">
						{{ csrf_field() }}

						@include('invoices.partials.item-form')

						<button type="submit" class="button is-primary">
							<span class="icon is-small">
								<i class="fa fa-save"></i>
							</span>
							<span>
								Add Item
							</span>
						</button>

					</form>

				</div>
				<div class="column is-6">

					<div class="box">
						@if (count($invoice->items))
							<table class="table is-striped is-fullwidth">
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
						@else
							<div class="notification">
								No items have been added to this invoice yet.
							</div>
						@endif
					</div>

				</div>
			</div>

		</div>
	</section>

@endsection