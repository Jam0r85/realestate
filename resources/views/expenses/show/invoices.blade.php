@component('partials.alerts.info')
	The invoices listed below will automatically be attached to rental statements when they are sent by e-mail.
@endcomponent

@component('partials.table')
	@slot('header')
		<th>Status</th>
		<th>Uploaded</th>
		<th>Name</th>
		<th></th>
	@endslot
	@slot('body')
		@foreach ($expense->documents as $document)
			<tr>
				<td>{{ $document->present()->status }}</td>
				<td>{{ date_formatted($document->created_at) }}</td>
				<td>{{ $document->name }}</td>
				<td class="text-right">
					<a href="{{ route('documents.edit', $document->id) }}" class="btn btn-warning btn-sm">
						Edit
					</a>
					@include('partials.document-download-button', ['path' => $document->path])
				</td>
			</tr>
		@endforeach
	@endslot
@endcomponent

<div class="card mb-3">
	@component('partials.card-header')
		Upload Invoices
	@endcomponent

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