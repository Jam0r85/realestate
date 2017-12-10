@extends('pdf._layout')
@section('content')

	<div class="container">
		<div class="content">

			<div class="section">
				<table>
					<tr>
						<td>{!! $invoice->present()->letterRecipient !!}</td>
						<td class="text-right">
							{!! $invoice->present()->branchAddress !!}
							@if ($vat_number = $invoice->present()->branchVatNumber)
								<p>{{ $vat_number }}</p>
							@endif
						</td>
					</tr>
				</table>
			</div>

			<div class="section">
				<h3 class="m-0 {{ $invoice->present()->status('class') }}">
					Invoice {{ $invoice->present()->name }}
				</h3>
				<h5 class="m-0">
					{{ $invoice->present()->fullDate }}
				</h5>
			</div>

			@if ($address = $invoice->present()->propertyAddress('full'))
			<div class="section">
				<ul class="list-unstyled">
					<li><strong>Property:</strong> {{ $address }}</li>
				</ul>
			</div>
			@endif

			<div class="section">
				<table class="table-list">
					<thead>
						<tr>
							<th>Item</th>
							<th>Net</th>
							<th>VAT</th>
							<th>Total</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($invoice->items as $item)
							<tr>
								<td>
									<b>{{ $item->name }}</b>
									@if ($item->quantity > 1)
										({{ $item->quantity }}x {{ currency($item->amount) }})
									@endif
									{!! $item->description ? '<br />' . $item->description : '' !!}
								</td>
								<td>{{ currency($item->total_net) }}</td>
								<td>{{ currency($item->total_tax) }}</td>
								<td>{{ currency($item->total) }}</td>
							</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<th>Totals</th>
							<th>{{ currency($invoice->present()->itemsTotalNet) }}</th>
							<th>{{ currency($invoice->present()->itemsTotalTax) }}</th>
							<th>{{ currency($invoice->present()->total) }}</th>
						</tr>
					</tfoot>
				</table>
			</div>

			<section class="section">
				@if ($invoice->present()->status == 'Paid')
					<h5 class="text-success">Paid</h5>
				@endif
				{{ $invoice->present()->paperTerms }}
			</section>

		</div>
	</div>

@endsection