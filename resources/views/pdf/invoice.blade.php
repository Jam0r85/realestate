@extends('pdf._layout')
@section('content')

	<div class="container">
		<div class="content">

			<div class="section">
				<table>
					<tr>
						<td>{!! $invoice->present()->recipient !!}</td>
						<td class="text-right">
							{!! $invoice->present()->branchAddress !!}
							<p>{!! $invoice->present()->vatNumber !!}</p>
						</td>
					</tr>
				</table>
			</div>

			<div class="section">
				<h3 class="m-0 {{ $invoice->present()->status('class') }}">
					{{ $invoice->present()->name }}
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
										({{ $item->quantity }}x {{ money_formatted($item->amount) }})
									@endif
									{!! $item->description ? '<br />' . $item->description : '' !!}
								</td>
								<td>{{ money_formatted($item->total_net) }}</td>
								<td>{{ money_formatted($item->total_tax) }}</td>
								<td>{{ money_formatted($item->total) }}</td>
							</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<th>Totals</th>
							<th>{{ money_formatted($invoice->present()->itemsTotalNet) }}</th>
							<th>{{ money_formatted($invoice->present()->itemsTotalTax) }}</th>
							<th>{{ money_formatted($invoice->present()->total) }}</th>
						</tr>
					</tfoot>
				</table>
			</div>

			<section class="section">
				@if ($invoice->isPaid())
					<h5 class="text-success mb-2">Paid {{ date_formatted($invoice->paid_at) }}</h5>
				@endif
				{!! $invoice->present()->terms !!}
			</section>

		</div>
	</div>

@endsection