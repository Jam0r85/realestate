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

			<div class="card mb-3">
				<div class="card-header">
					<i class="fa fa-upload"></i> Uploaded Invoices
				</div>
				<ul class="list-group list-group-flush">
					@foreach ($expense->invoices as $invoice)
						<li class="list-group-item">
							<div class="row">
								<div class="col">
									<input type="text" class="form-control" value="{{ $invoice->name }}" />
								</div>
								<div class="col">
									<a href="{{ Storage::url($invoice->path) }}" class="btn btn-primary" target="_blank">
										<i class="fa fa-download"></i> Download
									</a>
								</div>
								<div class="col text-right">
									<label class="custom-control custom-checkbox">
										<input class="custom-control-input" type="checkbox" name="remove[]" value="{{ $invoice->id }}" />
										<span class="custom-control-indicator"></span>
										<span class="custom-control-description">Remove?</span>
									</label>
								</div>
							</div>
						</li>
					@endforeach
				</ul>
			</div>

			<button type="submit" class="btn btn-primary">
				<i class="fa fa-save"></i> Save Changes
			</button>

		</div>
	</section>

@endsection