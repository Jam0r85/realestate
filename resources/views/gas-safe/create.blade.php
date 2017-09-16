@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<h1>New Gas Safe Reminder</h1>
			</div>

		</div>
	</section>

	<section class="section">
		<div class="container">

			@include('partials.errors-block')

			<form action="{{ route('gas-safe.store') }}" method="POST">
				{{ csrf_field() }}

				@include('gas-safe.partials.form')

				@component('partials.bootstrap.save-submit-button')
					Create Gas Safe Reminder
				@endcomponent

			</form>

		</div>
	</section>

@endsection