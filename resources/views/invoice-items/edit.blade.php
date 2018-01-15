@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">

			@if (count($item->invoice->statements))
				@foreach ($item->invoice->statements as $statement)
					@component('partials.return-button')
						{{ $statement->present()->name }}
						@slot('url')
							{{ route('statements.show', $statement->id) }}
						@endslot
					@endcomponent
				@endforeach
			@endif

			@component('partials.return-button')
				{{ $item->invoice->present()->name }}
				@slot('url')
					{{ route('invoices.show', $item->invoice->id) }}
				@endslot
			@endcomponent
		</div>

		@component('partials.header')
			Invoice #{{ $item->invoice->number }}
		@endcomponent

		@component('partials.sub-header')
			Edit invoice item
		@endcomponent

	@endcomponent

	@component('partials.section-with-container')

		@include('partials.errors-block')

		<div class="row">
			<div class="col-12 col-lg-6">

				<form method="POST" action="{{ route('invoice-items.update', $item->id) }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}

					@component('partials.card')
						@slot('header')
							Invoice Item Details
						@endslot
						@slot('body')

							@include('invoice-items.partials.form')

						@endslot
						@slot('footer')
							@component('partials.save-button')
								Save Changes
							@endcomponent
						@endslot

					@endcomponent

				</form>

			</div>
			<div class="col-12 col-lg-6">

				<form method="POST" action="{{ route('invoice-items.delete', $item->id) }}">
					{{ csrf_field() }}
					{{ method_field('DELETE') }}

					@component('partials.card')
						@slot('header')
							Destroy Invoice Item
						@endslot
						@slot('body')
							@component('partials.alerts.danger')
								@icon('warning') Destroying this invoice item will delete it permenantly.
							@endcomponent
						@endslot
						@slot('footer')
							@include('partials.forms.destroy-button')
						@endslot
					@endcomponent

				</form>

			</div>
		</div>

	@endcomponent

@endsection