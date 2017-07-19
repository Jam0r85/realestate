@extends('settings.template')

@section('sub-content')

	@component('partials.sections.section-no-container')
		@slot('title')
			Branches List
		@endslot

		@include('branches.partials.table', ['branches' => $branches])

	@endcomponent

	<form role="form" method="POST" action="{{ route('branches.store') }}">
		{{ csrf_field() }}

		@component('partials.sections.section-no-container')
			@slot('title')
				New Branch
			@endslot
			@slot('saveButton')
				Create Branch
			@endslot

			@include('partials.errors-block')

			@include('branches.partials.form')

		@endcomponent

	</form>

@endsection