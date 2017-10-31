@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			@component('partials.header')
				Create Gas Safe Inspection
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<form action="{{ route('gas-safe.store') }}" method="POST">
			{{ csrf_field() }}

			@include('gas-safe.partials.form')

			@component('partials.save-button')
				Create Gas Safe Reminder
			@endcomponent

		</form>

	@endcomponent

@endsection