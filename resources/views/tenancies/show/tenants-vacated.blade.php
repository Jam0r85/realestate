@extends('tenancies.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			Tenants Vacated
		@endcomponent

		<div class="content">
			<p>
				Are you sure that you want to record that the tenants of this tenancy have vacated the property?
			</p>
		</div>

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

			@component('partials.forms.buttons.primary')
				Yes, They Have Vacated
			@endcomponent
		</form>

	@endcomponent

@endsection