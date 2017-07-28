@extends('statements.show.layout')

@section('sub-content')

	@component('partials.sections.section-no-container')

		@component('partials.title')
			Items
		@endcomponent

		@component('partials.subtitle')
			Invoice Items
		@endcomponent

		@if (!$statement->hasInvoice())

			@component('partials.notifications.primary')
				Statement has no invoice items.
			@endcomponent

		@else

			@include('invoices.partials.item-table', ['items' => $statement->invoice->items])

		@endif

		@component('partials.subtitle')
			Expense Items
		@endcomponent

		@if (!count($statement->expenses))

			@component('partials.notifications.primary')
				Statement has no expense items.
			@endcomponent

		@else

			@include('expenses.partials.table', ['expenses' => $statement->expenses, 'amount' => true])

		@endif

	@endcomponent

@endsection