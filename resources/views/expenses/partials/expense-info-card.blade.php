<div class="card mb-3">

	@component('partials.bootstrap.card-header')
		Expense Details
	@endcomponent

	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{{ $expense->name }}
			@slot('title')
				Name
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ currency($expense->cost) }}
			@slot('title')
				Cost
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ currency($expense->remaining_balance) }}
			@slot('title')
				Balance
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ $expense->contractor ? $expense->contractor->name : '-' }}
			@slot('title')
				Contractor
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			<a href="{{ route('properties.show', $expense->property_id) }}" title="{{ $expense->property->name }}">
				{{ $expense->property->name }}
			</a>
			@slot('title')
				Property
			@endslot
		@endcomponent
	</ul>
</div>