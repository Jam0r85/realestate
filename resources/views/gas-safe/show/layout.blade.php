@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">
			<div class="float-right">
				@include('gas-safe.partials.dropdown-menus')
			</div>
			<h1>Gas Safe Reminder</h1>
			<h3 class="text-muted">{{ $reminder->property->short_name }}</h3>
		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

	@endcomponent

@endsection