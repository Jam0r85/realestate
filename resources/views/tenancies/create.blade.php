@extends('layouts.app')

@section('breadcrumbs')
	<li><a href="{{ route('tenancies.index') }}">Tenancies List</a></li>
	<li class="is-active"><a>New Tenancy</a></li>
@endsection

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			New Tenancy
		@endslot
	@endcomponent

	@component('partials.sections.section')

		<div class="field">
			<label class="label" for="property_id">Property</label>
			<div class="control">
				<select name="property_id" class="select2">
					<option value="">Please select..</option>
					@foreach (properties() as $property)
						<option value="{{ $property->id }}">{{ $property->name }}</option>
					@endforeach
				</select>
			</div>
		</div>

	@endcomponent

@endsection