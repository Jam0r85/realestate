@extends('layouts.setup')

@section('content')

	<section class="section">
		<div class="container">

			<h1 class="text-center">
				Application Setup
			</h1>

		</div>
	</section>

	<form role="form" method="POST" action="{{ Route('setup.store') }}">
		{{ csrf_field() }}

		<section class="section">
			<div class="container">

				<div class="row">
					<div class="col-sm-12 col-md-6 mr-md-auto ml-md-auto">

						@include('partials.errors-block')

						<div class="card mb-3">
							<div class="card-header">
								User
							</div>
							<div class="card-body">

								<div class="form-group">
									<label for="first_name">First Name</label>
									<input type="text" name="first_name" class="form-control" required value="{{ old('first_name') }}">
								</div>

								<div class="form-group">
									<label for="last_name">Last Name</label>
									<input type="text" name="last_name" class="form-control" required value="{{ old('last_name') }}">
								</div>

								<div class="form-group">
									<label for="email">E-Mail Address</label>
									<input type="email" name="email" class="form-control" required value="{{ old('email') }}">
								</div>

								<div class="form-group">
									<label for="password">Password</label>
									<input type="password" name="password" class="form-control" required>
								</div>

								<div class="form-group">
									<label for="password_confirmation">Confirm Password</label>
									<input type="password" name="password_confirmation" class="form-control" required>
								</div>

							</div>
						</div>

						<div class="card mb-3 border-info">
							<div class="card-header bg-info text-white">
								Basic Settings
							</div>
							<div class="card-body">

								<div class="form-group">
									<label for="company_name">Company Name</label>
									<input type="text" name="company_name" class="form-control" required value="{{ old('company_name') }}">
								</div>

								<div class="form-group">
									<label for="default_country">Default Country</label>
									<select name="default_county" class="form-control" require>
										<option>United Kingdom</option>
									</select>
								</div>

								<div class="form-group">
									<label for="public_url">Public Website URL</label>
									<input type="text" name="public_url" class="form-control" value="{{ old('public_url') }}" placeholder="http://">
								</div>

								<div class="form-group">
									<label for="vat_number">VAT Number</label>
									<input type="text" name="vat_number" class="form-control" value="{{ old('vat_number') }}">
									<small class="form-text text-muted">
										VAT registered? Enter your VAT number or leave it blank.
									</small>
								</div>

							</div>
						</div>

						<div class="card mb-3 border-primary">
							<div class="card-header bg-primary text-white">
								Branch
							</div>
							<div class="card-body">

								<div class="form-group">
									<label for="branch_name">Branch Name</label>
									<input type="text" name="branch_name" class="form-control" required value="{{ old('branch_name') }}">
								</div>

								<div class="form-group">
									<label for="branch_phone_numbner">Phone Number</label>
									<input type="text" name="branch_phone_number" class="form-control" required value="{{ old('branch_phone_number') }}">
								</div>

								<div class="form-group">
									<label for="branch_email">E-Mail</label>
									<input type="text" name="branch_email" class="form-control" required value="{{ old('branch_email') }}">
								</div>

							</div>
						</div>

					</div>
				</div>

				<div class="text-center">
					<button type="submit" class="btn btn-primary">
						Save Changes
					</button>
				</div>
				
			</div>
		</section>

	</form>

@endsection