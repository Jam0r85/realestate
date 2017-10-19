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

		<div class="row">
			<div class="col col-5">

				@include('gas-safe.partials.contractors-card')
				@include('gas-safe.partials.system-info-card')

			</div>
			<div class="col col-7">

				@include('gas-safe.partials.reminder-info-card')

			</div>
		</div>

	@endcomponent

@endsection