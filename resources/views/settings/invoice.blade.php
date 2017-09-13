@extends('settings.layout')

@section('settings-content')

	@include('partials.errors-block')

	<form role="form" method="POST" action="{{ route('settings.update-general') }}">
		{{ csrf_field() }}

		<section class="section">
			<div class="page-title">
				<h3>
					Invoice Settings
				</h3>
			</div>	

			<div class="form-group">
				<label for="invoice_default_terms">Default Invoice Terms</label>
				<textarea name="invoice_default_terms" rows="6" class="form-control">{{ get_setting('invoice_default_terms') }}</textarea>
			</div>

		</section>

		<button type="submit" class="btn btn-primary">
			<i class="fa fa-save"></i> Save Changes
		</button>

	</form>

@endsection