@extends('layouts.print')

@section('content')

	@component('partials.section-with-container')
		@include('sms.partials.message')
	@endcomponent

@endsection