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
				<h3 class="m-0 {{ $invoice->present()->statusClass }}">
					{{ $invoice->present()->name }}
				</h3>
				<h5 class="m-0">
					{{ $invoice->present()->dateCreated }}
				</h5>
			</div>

			@if ($invoice->property)
				<div class="section">
					<ul class="list-unstyled">
						<li><strong>Property:</strong> {{ $invoice->present()->propertyAddress }}</li>
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
										({{ $item->quantity }}x {{ $item->present()->money('amount') }})
									@endif
									<br />{!! $item->present()->descriptionWithDiscounts !!}
								</td>
								<td>{{ $item->present()->money('net') }}</td>
								<td>{{ $item->present()->money('tax') }}</td>
								<td>{{ $item->present()->money('total') }}</td>
							</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<th>Totals</th>
							<th>{{ $invoice->present()->money('net') }}</th>
							<th>{{ $invoice->present()->money('tax') }}</th>
							<th>{{ $invoice->present()->money('total') }}</th>
						</tr>
					</tfoot>
				</table>
			</div>

			<section class="section">
				@if ($invoice->paid_at)
					<h5 class="text-success mb-2">Paid {{ $invoice->present()->date('paid_at') }}</h5>
				@endif
				{!! $invoice->present()->termsLetter !!}
			</section>

		</div>
	</div>

@endsection