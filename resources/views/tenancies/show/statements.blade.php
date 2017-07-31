@extends('tenancies.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			Statements
		@endcomponent

		@include('statements.partials.table', ['statements' => $tenancy->statements, 'show_download' => true])

	@endcomponent

@endsection