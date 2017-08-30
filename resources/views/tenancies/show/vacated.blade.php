@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<a href="{{ route('tenancies.show', $tenancy->id) }}" class="button is-pulled-right">
				Return
			</a>

			<h1 class="title">{{ $tenancy->name }}</h1>
			<h2 class="subtitle">Record the tenants as vacating or having vacated.</h2>

			<hr />

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('tenancies.tenants-vacated', $tenancy->id) }}">
				{{ csrf_field() }}

				<div class="field">
					<label class="label" for="vacated_on">Date Vacated</label>
					<div class="control">
						<input type="date" name="vacated_on" class="input" value="{{ $tenancy->vacated_on ? $tenancy->vacated_on->format('Y-m-d') : old('vacated_on') }}" />
					</div>
				</div>

				<button type="submit" class="button is-primary">
					<span class="icon is-small">
						<i class="fa fa-save"></i>
					</span>
					<span>
						Save Changes
					</span>
				</button>
				
			</form>

		</div>
	</section>

@endsection