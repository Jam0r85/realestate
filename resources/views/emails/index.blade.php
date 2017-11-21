@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		@component('partials.header')
			Sent E-Mails History
		@endcomponent

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('emails.partials.emails-table')

		@include('partials.pagination', ['collection' => $emails])

	@endcomponent

@endsection