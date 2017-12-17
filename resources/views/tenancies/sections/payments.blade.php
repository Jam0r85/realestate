<div class="tab-pane fade @if (request('section') == 'payments') show active @endif" id="v-pills-payments" role="tabpanel">

	<a href="{{ route('rent-payments.print', $tenancy->id) }}" class="btn btn-secondary" target="_blank">
		<i class="fa fa-print"></i> Print
	</a>

	<a href="{{ route('rent-payments.print-with-statements', $tenancy->id) }}" class="btn btn-secondary" target="_blank">
		<i class="fa fa-print"></i> Print with Statements
	</a>

	@include('payments.partials.payments-table', ['payments' => $tenancy->rent_payments])

	@include('partials.pagination', ['collection' => $tenancy->rent_payments])
	
</div>