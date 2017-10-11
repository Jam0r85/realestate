@extends('settings.layout')

@section('settings-content')

	<p>The company logo is displayed both on the public website, invoices and rental statements.</p>

	@if (get_setting('company_logo'))

		<div class="card mb-3">
			<div class="card-body">

				<img src="{{ get_file(get_setting('company_logo')) }}" class="img-fluid" />

			</div>
			<div class="card-footer text-muted">

				<form role="form" method="POST" action="{{ route('settings.destroy-logo') }}">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}

					<button type="submit" class="btn btn-danger">
						<i class="fa fa-trash"></i> Remove Logo
					</button>

				</form>

			</div>
		</div>

	@endif

	<div class="card primary-border">
		<div class="card-header bg-primary text-white">
			Upload New Logo
		</div>
		<div class="card-body">

			<form role="form" method="POST" action="{{ route('settings.update-logo') }}" enctype="multipart/form-data">
				{{ csrf_field() }}

				<div class="form-group">
					<label for="company_logo">Select File</label>
					<input type="file" name="image" class="form-control" />
				</div>

				@component('partials.bootstrap.save-submit-button')
					Upload Logo
				@endcomponent

			</form>

		</div>
	</div>

@endsection