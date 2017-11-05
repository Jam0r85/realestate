@extends('layouts.app')

@section('content')

	@component('partials.bootstrap.section-with-container')

		<div class="page-title">

			@component('partials.return-button')
				@slot('url')
					@if ($item->invoice->statement)
						{{ route('statements.show', $item->invoice->statement->id) }}
					@else
						{{ route('invoices.show', $item->invoice->id) }}
					@endif
				@endslot
			@endcomponent

			@component('partials.header')
				Invoice #{{ $item->invoice->number }}
			@endcomponent

			@component('partials.sub-header')
				Edit invoice item
			@endcomponent

		</div>

	@endcomponent

	@component('partials.bootstrap.section-with-container')

		@include('partials.errors-block')

		<div class="card mb-3">

			@component('partials.card-header')
				Item Details
			@endcomponent

			<div class="card-body">

				<form method="POST" action="{{ route('invoices.update-item', $item->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					@include('invoices.partials.item-form')

					<button type="submit" class="btn btn-danger float-right" name="remove_item" value="true">
						<i class="fa fa-trash"></i> Remove Item
					</button>

					@component('partials.save-button')
						Save Changes
					@endcomponent

				</form>

			</div>
		</div>

	@endcomponent

@endsection