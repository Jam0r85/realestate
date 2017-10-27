<div class="card mb-3">

	@component('partials.bootstrap.card-header')
		Uploaded Invoices
	@endcomponent

	@if (count($expense->documents))

		<ul class="list-group list-group-flush">

			@foreach ($expense->documents as $invoice)

				<li class="list-group-item">
					<a href="{{ Storage::url($invoice->path) }}" target="_blank" title="{{ $invoice->name }}">
						{{ $invoice->name }}
					</a>
					<small class="d-block">Uploaded {{ date_formatted($invoice->created_at) }}</small>
				</li>

			@endforeach

		</ul>

	@else

		<div class="card-body">
			No invoices have been uploaded and added to this expense.
		</div>

	@endif

	<div class="card-body">

		<form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data">
			{{ csrf_field() }}

			<input type="hidden" name="expense_id" value="{{ $expense->id }}" />

			<div class="form-group">
				<label for="files">Upload Invoice(s)</label>
				<input type="file" name="files[]" id="files" multiple class="form-control-file">
			</div>

			@component('partials.save-button')
				Upload Invoices
			@endcomponent

		</form>

	</div>
</div>