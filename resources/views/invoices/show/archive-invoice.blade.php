@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-secondary float-right">
					Return
				</a>
				<h1>Invoice #{{ $invoice->number }}</h1>
				<h3>Archive invoice</h3>
			</div>

		</div>
	</section>

	<section class="section">
		<div class="container">

			@include('partials.errors-block')

			@if ($invoice->trashed())

				<div class="card mb-3">
					<div class="card-body">
						<h4 class="card-title">
							Restore Invoice
						</h4>
						<p class="card-text">
							You can restore this invoice and bring it back to life.
						</p>

						<form role="form" method="POST" action="{{ route('invoices.restore', $invoice->id) }}">
							{{ csrf_field() }}

							<button type="submit" class="btn btn-secondary">
								<i class="fa fa-save"></i> Restore Invoice
							</button>

						</form>
					</div>
				</div>

			@else

				<div class="card mb-3">
					<div class="card-body">
						<h4 class="card-title">
							Archive Invoice
						</h4>
						<p class="card-text">
							You can archive or 'soft delete' this invoice and hide it from public view. An archived invoice can be restored back as and when required.
						</p>

						<form role="form" method="POST" action="{{ route('invoices.archive', $invoice->id) }}">
							{{ csrf_field() }}

							<button type="submit" class="btn btn-secondary">
								<i class="fa fa-archive"></i> Archive Invoice
							</button>

						</form>
					</div>
				</div>

			@endif

			<div class="card border-danger mb-3">
				<div class="card-body">
					<h4 class="card-title">
						Destroy Invoice
					</h4>
					<p class="card-text">
						You can also destroy this invoice which will permenantly remove it from the system. Destroying an invoice will also delete all invoice items and payments attached to the invoice.
					</p>
					<div class="alert alert-danger">
						<b>Important!</b> A destroyed invoice cannot be restored. Make sure you want to do this!
					</div>

					<form role="form" method="POST" action="{{ route('invoices.destroy', $invoice->id) }}">
						{{ csrf_field() }}
						{{ method_field('DELETE') }}

						<div class="form-group">
							<label for="confirmation">Enter the ID of this invoice to confirm that you wish to destroy it.</label>
							<input type="number" class="form-control" name="confirmation">
						</div>

						<button type="submit" class="btn btn-danger">
							<i class="fa fa-trash"></i> Destroy Invoice
						</button>

					</form>
				</div>
			</div>

		</div>
	</section>

@endsection