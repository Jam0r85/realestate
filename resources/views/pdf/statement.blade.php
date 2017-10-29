@include('pdf._header')

	<section class="section">
		<div class="container">

			<table>
				<tr>
					<td>
						<p>{{ implode(' & ', $statement->users->pluck('name')->toArray()) }}</p>
						<p>{!! $statement->recipient !!}</p>
					</td>
					<td class="has-text-right">
						{!! $statement->tenancy->property->branch->address_formatted !!}
					</td>
				</tr>
			</table>

		</div>
	</section>

	<section class="section">
		<div class="container">
			<h1 class="title">
				Rental Statement
			</h1>
			<h2 class="subtitle">
				{{ longdate_formatted($statement->created_at) }}
			</h2>
		</div>
	</section>

	<section class="section">
		<div class="container">

			<ul class="list-unstyled">
				<li><strong>Rental Period:</strong> {{ longdate_formatted($statement->period_start) }} - {{ longdate_formatted($statement->period_end) }}</li>
				<li><strong>Property:</strong> {{ $statement->property->name }}</li>
				<li><strong>{{ str_plural('Tenant', count($statement->tenancy->tenants)) }}:</strong> {{ $statement->tenancy->name }}</li>
			</ul>

		</div>
	</section>

	<section class="section">
		<div class="container">

			<table class="table is-striped is-bordered">
				<thead>
					<tr>
						<th>Rent Received</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{ currency($statement->amount) }}</td>
					</tr>
				</tbody>
			</table>

			<table class="table is-striped is-bordered">
				<thead>
					<tr>
						<th>Deductions</th>
						<th class="">Net</th>
						<th class="">Vat</th>
						<th class="">Total</th>
					</tr>
				</thead>
				<tbody>

					@if($statement->invoice)
						@foreach ($statement->invoice->items as $item)
							<tr>
								<td>
									<b>{{ $item->name }} (Inv. #{{ $item->invoice->number }})</b>
									{!! $item->description ? '<br />' . $item->description : '' !!}
									@if (strpos(strtolower($item->description), 'service') && $statement->tenancy->service_discounts)
										<br />
										@foreach ($statement->tenancy->service_discounts as $discount)
											<small>Includes {{ strtolower($discount->name) }} of {{ $discount->amount_formatted }}</small> <br />
										@endforeach
									@endif
								</td>
								<td class="">{{ currency($item->total_net) }}</td>
								<td class="">{{ currency($item->total_tax) }}</td>
								<td class="">{{ currency($item->total) }}</td>
							</tr>
						@endforeach
					@endif

					@foreach ($statement->expenses as $expense)
						<tr>
							<td>
								
								<b>{{ $expense->name }}</b>

								@if ($expense->contractor)
									<br />{{ $expense->contractor->name }}
								@endif

								@if ($expense->pivot->amount != $expense->cost)
									<small>(Part Payment)</small>
								@endif

							</td>
							<td class="">{{ currency($expense->pivot->amount) }}</td>
							<td></td>
							<td class="">{{ currency($expense->pivot->amount) }}</td>
						</tr>
					@endforeach

				</tbody>
				<tfoot>
					<tr>
						<th>Sub Totals</th>
						<th class="">{{ currency($statement->net_amount) }}</th>
						<th class="">{{ currency($statement->tax_amount) }}</th>
						<th class="">{{ currency($statement->total_amount) }}</th>
					</tr>
				</tfoot>
			</table>

		</div>
	</section>

	<section class="section">
		<div class="container">
			<table>
				<tr>
					<td width="50%">
						@if ($statement->property->bank_account)
							<p>
								<b>BACS:</b> {{ $statement->property->bank_account->account_name }} / {{ $statement->property->bank_account->sort_code }} / {{ $statement->property->bank_account->account_number }}
							</p>
						@else
							<p>Cheque or Cash</p>
						@endif
						@if ($statement->sendByEmail())
							<p>Send by E-Mail</p>
						@endif
					</td>
					<td width="50%" class="has-text-right"
						<b>{{ currency($statement->landlord_balance_amount) }}</b> balance to landlord
					</td>
				</tr>
			</table>
		</div>
	</section>

	{{-- Attach the Invoice --}}
	@if ($statement->invoice)
		<div class="page-break"></div>
		@include('pdf.invoice', ['invoice' => $statement->invoice])
	@endif

@include('pdf._footer')