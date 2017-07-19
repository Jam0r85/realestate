@extends('invoices.show.layout')

@section('sub-content')

	<h2 class="title is-3">
		Add Item
	</h2>

	@include('partials.errors-block')

	<form role="form" method="POST" action="{{ route('invoices.create-item', $invoice->id) }}">
		{{ csrf_field() }}

		@include('invoices.partials.item-form')

		<button type="submit" class="button is-primary is-outlined">
			Store Item
		</button>

	</form>

@endsection