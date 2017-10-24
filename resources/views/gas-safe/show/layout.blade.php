@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">
			
			<div class="float-right">
				@include('gas-safe.partials.dropdown-menus')
			</div>

			@component('partials.header')
				{{ $gas->property->short_name }}
			@endcomponent

			@component('partials.sub-header')
				Gas inspection reminder
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@if ($gas->is_completed)

			<div class="alert alert-success">
				This gas inspection has been marked as completed.
			</div>

		@endif

		<div class="row">
			<div class="col col-5">

				@include('gas-safe.partials.contractors-card')
				@include('gas-safe.partials.system-info-card')

			</div>
			<div class="col col-7">

				@include('gas-safe.partials.gas-info')
				@include('gas-safe.partials.reminders-list')

			</div>
		</div>

	@endcomponent

@endsection