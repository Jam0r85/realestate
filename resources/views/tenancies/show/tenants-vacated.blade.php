@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<a href="{{ route('tenancies.show', $tenancy->id) }}" class="btn btn-secondary float-right">
					Return
				</a>
				<h1>{{ $tenancy->name }}</h1>
				<h3>Record the tenants as vacating or having vacated.</h3>
			</div>

		</div>
	</section>

	<section class="section">
		<div class="container">

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('tenancies.tenants-vacated', $tenancy->id) }}">
				{{ csrf_field() }}

				<div class="form-group">
					<label for="vacated_on">Date Vacated (or vacating)</label>
					<input type="date" name="vacated_on" class="form-control" value="{{ $tenancy->vacated_on ? $tenancy->vacated_on->format('Y-m-d') : old('vacated_on') }}" />
				</div>

				@component('partials.bootstrap.save-submit-button')
					Save Changes
				@endcomponent
				
			</form>

		</div>
	</section>

@endsection