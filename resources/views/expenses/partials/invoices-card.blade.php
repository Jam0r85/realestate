<div class="card text-white @if (count($expense->invoices)) bg-success @else bg-danger @endif mb-3">
	<div class="card-header">
		<i class="fa fa-upload"></i> Invoices
	</div>

	@if (count($expense->invoices))

		<ul class="list-group list-group-flush">
			@foreach ($expense->invoices as $invoice)
				@component('partials.bootstrap.list-group-item')
					<a href="#" target="_blank">
						{{ $invoice->name }}
					</a>
				@endcomponent
			@endforeach
		</ul>

	@else
		<div class="card-body">
			<b>No invoices uploaded!</b>
		</div>
	@endif

</div>