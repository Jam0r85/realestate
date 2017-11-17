@extends('settings.layout')

@section('settings-content')

	@include('partials.errors-block')

	<form role="form" method="POST" action="{{ route('settings.update') }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}

		<div class="form-group">
			<label for="company_name">Company Name</label>
			<input type="text" name="company_name" class="form-control" value="{{ get_setting('company_name') }}" />
		</div>

		<button type="submit" class="btn btn-primary">
			<i class="fa fa-save"></i> Save Changes
		</button>

	</form>

@endsection