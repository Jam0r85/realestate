<div class="card mb-3 @if (!count($expense->invoices)) border-danger @endif">
	<div class="card-header text-white @if (count($expense->invoices)) bg-success @else bg-danger @endif">
		<i class="fa fa-upload"></i> Invoices
	</div>

	@if (count($expense->invoices))

		<ul class="list-group list-group-flush">
			@foreach ($expense->invoices as $invoice)
				@component('partials.bootstrap.list-group-item')
					<a href="{{ Storage::url($invoice->path) }}" target="_blank" title="{{ $invoice->name }}">
						{{ $invoice->name }}
					</a>
				@endcomponent
			@endforeach
		</ul>

	@else

		<div class="card-body">
			No invoices have been uploaded and added to this expense.
		</div>

	@endif

</div>