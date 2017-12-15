@extends('layouts.app')

@section('content')

	@component('partials.page-header')

		<div class="float-right">
			<div class="btn-group">
				<button class="btn btn-secondary dropdown-toggle" type="button" id="paymentOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Options
				</button>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="paymentOptionsDropdown">
					<a class="dropdown-item" href="{{ route('payments.edit', $payment->id) }}" title="Edit Payment Details">
						<i class="fa fa-edit"></i> Edit Payment
					</a>
					<a class="dropdown-item" href="{{ route('downloads.payment', $payment->id) }}" title="Download Receipt" target="_blank">
						<i class="fa fa-download"></i> Download Receipt
					</a>
				</div>
			</div>
		</div>

		@component('partials.header')
			Payment {{ $payment->id }}
		@endcomponent
		
	@endcomponent

	@component('partials.section-with-container')

		<div class="card mb-3">

			@component('partials.card-header')
				Payment Information
			@endcomponent

			<ul class="list-group list-group-flush">
				@component('partials.bootstrap.list-group-item')
					{{ currency($payment->amount) }}
					@slot('title')
						Amount
					@endslot
				@endcomponent

				@component('partials.bootstrap.list-group-item')
					{{ $payment->method->name }}
					@slot('title')
						Payment Method
					@endslot
				@endcomponent

				@if ($payment->isInvoice())

					@component('partials.bootstrap.list-group-item')
						<a href="{{ route('invoices.show', $payment->parent->id) }}" title="{{ $payment->parent->name }}">
							{{ $payment->parent->name }}
						</a>
						@slot('title')
							Invoice
						@endslot
					@endcomponent

					@if ($payment->parent->property)
						@component('partials.bootstrap.list-group-item')
							<a href="{{ route('properties.show', $payment->parent->property->id) }}">
								{{ $payment->parent->property->present()->fullAddress }}
							</a>
							@slot('title')
								Property
							@endslot
						@endcomponent
					@endif

				@elseif ($payment->isRent())

					@component('partials.bootstrap.list-group-item')
						<a href="{{ route('tenancies.show', $payment->parent->id) }}">
							{{ $payment->parent->present()->name }}
						</a>
						@slot('title')
							Tenancy
						@endslot
					@endcomponent
					@component('partials.bootstrap.list-group-item')
						<a href="{{ route('properties.show', $payment->parent->property->id) }}">
							{{ $payment->parent->property->present()->fullAddress }}
						</a>
						@slot('title')
							Property
						@endslot
					@endcomponent

				@elseif ($payment->isDeposit())

					@component('partials.bootstrap.list-group-item')
						<a href="{{ route('tenancies.show', $payment->parent->id) }}">
							{{ $payment->parent->tenancy->present()->name }}
						</a>
						@slot('title')
							Tenancy
						@endslot
					@endcomponent

				@endif

			</ul>
		</div>

		<div class="card mb-3">
			@component('partials.card-header')
				System Information
			@endcomponent
			<ul class="list-group list-group-flush">
				@component('partials.bootstrap.list-group-item')
					{{ $payment->owner->name }}
					@slot('title')
						Created By
					@endslot
				@endcomponent
				@component('partials.bootstrap.list-group-item')
					{{ date_formatted($payment->created_at) }}
					@slot('title')
						Recorded
					@endslot
				@endcomponent
				@component('partials.bootstrap.list-group-item')
					{{ datetime_formatted($payment->updated_at) }}
					@slot('title')
						Updated
					@endslot
				@endcomponent
			</ul>
		</div>

	@endcomponent

@endsection