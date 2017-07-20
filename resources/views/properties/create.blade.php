@extends('layouts.app')

@section('breadcrumbs')
	<li><a href="{{ route('properties.index') }}">Properties List</a></li>
	<li class="is-active"><a>Create Property</a></li>
@endsection

@section('content')

	@component('partials.sections.hero.container')
		@slot('title')
			Create Property
		@endslot
	@endcomponent

	@component('partials.sections.section')

		@include('partials.errors-block')

		<form role="form" method="POST" action="{{ route('properties.store') }}">
			{{ csrf_field() }}

			<div class="field">
				<label class="label" for="branch_id">Branch</label>
				<p class="control is-expanded">
					<span class="select is-fullwidth">
						<select name="branch_id">
							@foreach (branches() as $branch)
								<option value="{{ $branch->id }}">{{ $branch->name }}</option>
							@endforeach
						</select>
					</span>
				</p>
			</div>

			@include('properties.partials.form')

			@component('partials.forms.buttons.primary')
				Create Property
			@endcomponent

		</form>

	@endcomponent

@endsection