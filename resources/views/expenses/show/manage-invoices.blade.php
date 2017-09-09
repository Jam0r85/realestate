@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<a href="{{ route('expenses.show', $expense->id) }}" class="btn btn-secondary float-right">
					Return
				</a>
				<h1>{{ $expense->name }}</h1>
				<h3>Manage invoices</h3>
			</div>

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('expenses.update-invoices', $expense->id) }}" enctype="multipart/form-data">
				{{ csrf_field() }}

				<div class="card mb-3">
					<div class="card-header">
						<i class="fa fa-upload"></i> Uploaded Invoices
					</div>
					<table class="table table-striped table-responsive">
						<thead>
							<th>#</th>
							<th>Name</th>
							<th>Preview</th>
							<th>Private</th>
							<th class="text-right">Delete</th>
						</thead>
						<tbody>
							@foreach ($expense->invoices as $invoice)
								<tr>
									<td>{{ $invoice->id }}</td>
									<td>
										<input type="hidden" name="invoice_id[]" value="{{ $invoice->id }}">
										<input type="text" class="form-control" name="invoice_name[]" value="{{ $invoice->name }}">
									</td>
									<td>
										<a href="{{ Storage::url($invoice->path) }}" target="_blank">
											<i class="fa fa-download"></i> Download
										</a>
									</td>
									<td></td>
									<td class="text-right">
										<label class="custom-control custom-checkbox">
											<input class="custom-control-input" type="checkbox" name="invoice_delete[]" value="{{ $invoice->id }}" />
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description"></span>
										</label>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>

					<div class="card mb-3">
						<div class="card-body">

							<div class="form-group">
								<label for="new_users">
									Search and upload new invoices
								</label>
								<input type="file" name="new_invoices[]" multiple class="form-control-file">
							</div>

						</div>
					</div>

				<button type="submit" class="btn btn-primary">
					<i class="fa fa-save"></i> Save Changes
				</button>

			</form>

		</div>
	</section>

@endsection