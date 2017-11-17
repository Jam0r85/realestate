@include('pdf._header')

	<div class="container">
		<div class="content">

			<div class="section">
				<table>
					<tr>
						<td>{!! $statement->present()->recipient !!}</td>
						<td class="text-right">
							{!! $statement->present()->branchAddress !!}
							@if ($vat_number = $statement->present()->branchVatNumber)
								<p>{{ $vat_number }}</p>
							@endif
						</td>
					</tr>
				</table>
			</div>

			<div class="section">
				<h3 class="m-0">
					Rental Statement
				</h3>
				<h5 class="m-0">
					{{ $statement->present()->fullDate }}
				</h5>
			</div>

			<div class="section">
				<ul class="list-unstyled">
					<li><strong>Rental Period:</strong> {{ $statement->present()->period }}</li>
					<li><strong>Property:</strong> {{ $statement->property->present()->fullAddress }}</li>
					<li><strong>{{ str_plural('Tenant', count($statement->tenancy->tenants)) }}:</strong> {{ $statement->present()->tenants }}</li>
				</ul>
			</div>

			<div class="section">
				<table class="table-list">
					<thead>
						<tr>
							<th>Rent Received</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>{{ $statement->present()->formattedAmount }}</td>
						</tr>
					</tbody>
				</table>
				<table class="table-list">
					<thead>
						<tr>
							<th>Deductions</th>
							<th>Net</th>
							<th>VAT</th>
							<th>Total</th>
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
									<td>{{ currency($item->total_net) }}</td>
									<td>{{ currency($item->total_tax) }}</td>
									<td>{{ currency($item->total) }}</td>
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
								<td>{{ currency($expense->pivot->amount) }}</td>
								<td></td>
								<td>{{ currency($expense->pivot->amount) }}</td>
							</tr>
						@endforeach

					</tbody>
					<tfoot>
						<tr>
							<th>Sub Totals</th>
							<th>{{ currency($statement->net_amount) }}</th>
							<th>{{ currency($statement->tax_amount) }}</th>
							<th>{{ currency($statement->total_amount) }}</th>
						</tr>
					</tfoot>
				</table>
			</div>

			<div class="section">
				<table>
					<tr>
						<td>
							{{ $statement->present()->paymentMethod }}<br />
							{{ $statement->present()->sendBy }}
						</td>
						<td class="text-right">
							Balance to Landlord - <b>{{ currency($statement->landlord_balance_amount) }}</b>
						</td>
					</tr>
				</table>
			</div>

		</div>
	</div>

	{{-- Attach the Invoice --}}
	@if ($statement->invoice)
		<div class="page-break"></div>
		@include('pdf.invoice', ['invoice' => $statement->invoice])
	@endif

@include('pdf._footer')