		</div>
		
		<div class="footer">
			<ul>
				{{-- Invoice footer taken from it's group and branch --}}
				@if (isset($statement))

					@if ($statement->tenancy->property->branch)
						<li>
							<span class="footer-title">Phone</span>
							{{ $statement->tenancy->property->branch->phone_number }}
						</li>
						<li>
							<span class="footer-title">E-Mail</span>
							{{ $statement->tenancy->property->branch->email }}
						</li>
					@endif

				@elseif (isset($invoice))

					@if ($invoice->invoiceGroup && $invoice->invoiceGroup->branch)
						<li>
							<span class="footer-title">Phone</span>
							{{ $invoice->invoiceGroup->branch->phone_number }}
						</li>
						<li>
							<span class="footer-title">E-Mail</span>
							{{ $invoice->invoiceGroup->branch->email }}
						</li>
					@endif

				@elseif (isset($payment))

					@if ($payment->parent_type == 'tenancies')

						<li>
							<span class="footer-title">Phone</span>
							{{ $payment->parent->property->branch->phone_number }}
						</li>
						<li>
							<span class="footer-title">E-Mail</span>
							{{ $payment->parent->property->branch->email }}
						</li>

					@endif

				@endif

				{{-- VAT Number taken from settings --}}
				@if (get_setting('vat_number'))
					<li>
						<span class="footer-title">VAT #</span>
						{{ get_setting('vat_number') }}
					</li>
				@endif
			</ul>
		</div>

	</body>
</html>