@extends('tenancies.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			Statements
		@endcomponent

		@component('partials.subtitle')
			Statements History
		@endcomponent

		@include('statements.partials.table', ['statements' => $tenancy->statements, 'show_download' => true])

	@endcomponent

@endsection