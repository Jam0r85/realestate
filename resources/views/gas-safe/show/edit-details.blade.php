@extends('layouts.app')

@section('content')

	<section class="section">
		<div class="container">

			<div class="page-title">
				<a href="{{ route('gas-safe.show', $reminder->id) }}" class="btn btn-secondary float-right">
					Return
				</a>
				<h1>{{ $reminder->property->short_name }} Gas Safe Reminder</h1>
				<h3>Edit reminder details</h3>
			</div>

			@include('partials.errors-block')

			<form role="form" method="POST" action="{{ route('gas-safe.update', $reminder->id) }}">
				{{ csrf_field() }}
				{{ method_field('PUT') }}			

				@include('gas-safe.partials.form')

				@component('partials.bootstrap.save-submit-button')
					Save Changes
				@endcomponent

			</form>

		</div>
	</section>

@endsection