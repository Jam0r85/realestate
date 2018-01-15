@extends('layouts.app')

@section('content')

	@component('partials.section-with-container')

		<h2>
			Unauthorized
		</h2>

		<p class="lead">
			{{ $exception->getMessage() }}
		</p>

		<a href="{{ url()->previous() }}" class="btn btn-secondary">
			Go Back
		</a>

	@endcomponent

@endsection