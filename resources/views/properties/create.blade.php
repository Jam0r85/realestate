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

	<form role="form" method="POST" action="{{ route('properties.store') }}">
		{{ csrf_field() }}

		@component('partials.sections.section')
			@slot('title')
				Property Details
			@endslot
			@slot('saveButton')
				Create Property
			@endslot

			@include('partials.errors-block')

			<div class="field">
				<label class="label" for="branch_id">Branch</label>
				<p class="control">
					<span class="select">
						<select name="branch_id">
							@foreach (branches() as $branch)
								<option value="{{ $branch->id }}">{{ $branch->name }}</option>
							@endforeach
						</select>
					</span>
				</p>
			</div>

			@include('properties.partials.form')
		@endcomponent

	</form>

@endsection