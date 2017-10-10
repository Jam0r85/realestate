@extends('settings.layout')

@section('settings-content')

	@include('partials.errors-block')

	<form role="form" method="POST" action="{{ route('settings.update') }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}

		<div class="form-group">
			<label for="invoice_default_terms">Default Invoice Terms</label>
			<textarea name="invoice_default_terms" rows="6" class="form-control">{{ get_setting('invoice_default_terms') }}</textarea>
		</div>

		<button type="submit" class="btn btn-primary">
			<i class="fa fa-save"></i> Save Changes
		</button>

	</form>

@endsection