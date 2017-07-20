@extends('invoices.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')	

		@component('partials.title')
			Delete Invoice
		@endcomponent

		@if ($invoice->paid_at || count($invoice->payments) || $invoice->deleted_at)

			@component('partials.notifications.primary')
				You cannot delete this invoice as it is paid, archived or has payments recorded against it.
			@endcomponent

		@else

			<form role="form" method="POST" action="{{ route('invoices.archive', $invoice->id) }}">
				{{ csrf_field() }}

				@component('partials.forms.buttons.primary')
					Delete
				@endcomponent

			</form>

		@endif

	@endcomponent

@endsection