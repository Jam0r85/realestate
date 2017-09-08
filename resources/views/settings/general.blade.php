@extends('settings.layout')

@section('settings-content')

	@include('partials.errors-block')

	<form role="form" method="POST" action="{{ route('settings.update-general') }}">
		{{ csrf_field() }}

		<section class="section">
			<div class="page-title">
				<h3>
					General Settings
				</h3>
			</div>	

			<div class="form-group">
				<label for="company_name">Company Name</label>
				<input type="text" name="company_name" class="form-control" value="{{ get_setting('company_name') }}" />
			</div>

			<div class="form-group">
				<label for="head_office_phone">Head Office Phone Number</label>
				<input type="text" name="head_office_phone" class="form-control" value="{{ get_setting('head_office_phone') }}" />
			</div>

			<div class="form-group">
				<label for="head_office_email">Head Office E-Mail</label>
				<input type="text" name="head_office_email" class="form-control" value="{{ get_setting('head_office_email') }}" />
			</div>

			<div class="form-group">
				<label for="vat_number">VAT Number</label>
				<input type="text" name="vat_number" class="form-control" value="{{ get_setting('vat_number') }}" />
				<small class="form-text text-muted">
					VAT registered? Enter your number to appear on invoices and statements.
				</small>
			</div>

		</section>

		<button type="submit" class="btn btn-primary">
			<i class="fa fa-save"></i> Save Changes
		</button>

	</form>

@endsection