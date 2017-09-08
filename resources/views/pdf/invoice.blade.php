@extends('pdf._layout')

@section('content')

	<section class="section">
		<div class="container">
			<div class="recipient">
				<p>{{ implode(' & ', $invoice->users->pluck('name')->toArray()) }}</p>
				<p>
					@if ($invoice->statement)
						{!! $invoice->statement->recipient !!}
					@else
						{!! nl2br($invoice->recipient) !!}
					@endif
				</p>
			</div>
		</div>
	</section>

	{{-- Title --}}
	<section class="section">
		<div class="container">
			<h1 class="title">
				Invoice {{ $invoice->number }}
			</h1>
			<h2 class="subtitle">
				{{ longdate_formatted($invoice->created_at) }}
			</h2>
		</div>
	</section>

	{{-- Details Listing --}}
	<section class="section">
		<div class="container">
			<ul class="list-unstyled">
				<li><strong>Property:</strong> {{ $invoice->property->name }}</li>
			</ul>
		</div>
	</section>

	{{-- Items --}}
	<section class="section">
		<div class="container">
			<table class="table is-striped is-bordered">
				<thead>
					<tr>
						<th>Item</th>
						<th class="">Net</th>
						<th class="">VAT</th>
						<th class="">Total</th>
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
							<td class="">{{ currency($item->total_net) }}</td>
							<td class="">{{ currency($item->total_tax) }}</td>
							<td class="">{{ currency($item->total) }}</td>
						</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<td>Totals</td>
						<td class="">{{ currency($invoice->total_net) }}</td>
						<td class="">{{ currency($invoice->total_tax) }}</td>
						<td class="">{{ currency($invoice->total) }}</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</section>

	<section class="section">
		<div class="container">
			@if ($invoice->terms)
				<div class="invoice-terms">
					<b>Invoice Terms</b>
					<p>{!! nl2br($invoice->terms) !!}</p>
				</div>
			@endif
		</div>
	</section>

@endsection