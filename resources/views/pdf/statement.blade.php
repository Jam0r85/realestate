@include('pdf._header')

	<div class="container">
		<div class="content">

			<div class="section">
				<table>
					<tr>
						<td>{!! $statement->present()->letterRecipient !!}</td>
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
					<li><strong>Property:</strong> {{ $statement->property()->present()->fullAddress }}</li>
					<li><strong>{{ str_plural('Tenant', count($statement->tenancy->users)) }}:</strong> {{ $statement->present()->tenants }}</li>
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
							<td>{{ money_formatted($statement->amount) }}</td>
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

						@if(count($statement->invoices))
							@foreach ($statement->invoices as $invoice)
								@foreach ($invoice->items as $item)
									<tr>
										<td>
											<b>{{ $item->name }} ({{ $item->invoice->present()->name }})</b>
											{!! $item->description ? '<br />' . $item->description : '' !!}
											@if (strpos(strtolower($item->description), 'service') && $statement->tenancy->serviceDiscounts)
												<br />
												@foreach ($statement->tenancy->serviceDiscounts as $discount)
													<small>Discount - {{ $discount->present()->nameWithAmount }}</small> <br />
												@endforeach
											@endif
										</td>
										<td>{{ $item->present()->money('net') }}</td>
										<td>{{ $item->present()->money('tax') }}</td>
										<td>{{ $item->present()->money('total') }}</td>
									</tr>
								@endforeach
							@endforeach
						@endif

						@foreach ($statement->expenses as $expense)
							<tr>
								<td>									
									<b>{{ $expense->name }}</b>
									@if ($expense->contractor)
										<br />{{ $expense->contractor->present()->fullName }}
									@endif
									@if ($expense->pivot->amount != $expense->cost)
										<small>(Part Payment)</small>
									@endif
								</td>
								<td>{{ money_formatted($expense->pivot->amount) }}</td>
								<td></td>
								<td>{{ money_formatted($expense->pivot->amount) }}</td>
							</tr>
						@endforeach

					</tbody>
					<tfoot>
						<tr>
							<th>Sub Totals</th>
							<th>{{ $statement->present()->money('net') }}</th>
							<th>{{ $statement->present()->money('tax') }}</th>
							<th>{{ $statement->present()->money('total_cost') }}</th>
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
							Balance to Landlord <b>{{ $statement->present()->money('landlord_payment') }}</b>
						</td>
					</tr>
				</table>
			</div>

		</div>
	</div>

	{{-- Attach the Invoice --}}
	@if (count($statement->invoices))
		@foreach ($statement->invoices as $invoice)
			<div class="page-break"></div>
			@include('pdf.invoice', ['invoice' => $invoice])
		@endforeach
	@endif

@include('pdf._footer')