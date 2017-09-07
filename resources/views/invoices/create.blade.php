@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>New Invoice</h1>
			</div>

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('invoices.store') }}">
				{{ csrf_field() }}					

				<div class="form-group">
					<label for="invoice_group_id">Invoice Group</label>
					<select name="invoice_group_id" class="form-control">
						@foreach (invoiceGroups() as $invoice_group)
							<option value="{{ $invoice_group->id }}">{{ $invoice_group->name }}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group">
					<label for="property_id">Property</label>
					<select name="property_id" class="form-control select2">
						<option value="" disabled selected></option>
						@foreach (properties() as $property)
							<option value="{{ $property->id }}">{{ $property->name }}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group">
					<label for="users">Users</label>
					<select name="users[]" class="form-control select2" multiple>
						@foreach (users() as $user)
							<option value="{{ $user->id }}">{{ $user->name }}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group">
					<label for="number">Overwrite Invoice Number</label>
					<input type="number" name="number" class="form-control" />
				</div>

				<div class="form-group">
					<label for="terms">Terms</label>
					<textarea name="terms" class="form-control">{{ get_setting('invoice_default_terms') }}</textarea>
				</div>

				<button type="submit" class="btn btn-primary">
					<i class="fa fa-save"></i> Create Invoice
				</button>

			</form>

		</div>
	</section>

@endsection