@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			<a href="{{ route('statements.show', $statement->id) }}" class="btn btn-secondary float-right">
				Return
			</a>

			@component('partials.header')
				Statement #{{ $statement->id }}
			@endcomponent

			@component('partials.sub-header')
				Create Invoice Item
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<form role="form" method="POST" action="{{ route('statements.create-invoice-item', $statement->id) }}">
			{{ csrf_field() }}

			@include('invoice-items.form', ['invoice' => $statement->invoice])

			@component('partials.save-button')
				Save Item
			@endcomponent

		</form>

	@endcomponent

@endsection