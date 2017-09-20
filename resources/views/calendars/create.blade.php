@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>New Calendar</h1>
			</div>

		</div>
	</section>

	<section class="section">
		<div class="container">

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('calendars.store') }}">
				{{ csrf_field() }}

				@include('calendars.partials.form')

				@component('partials.bootstrap.save-submit-button')
					Create Calendar
				@endcomponent

			</form>

		</div>
	</section>

@endsection