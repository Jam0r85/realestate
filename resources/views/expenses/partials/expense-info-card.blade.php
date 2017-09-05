<div class="card mb-3">
	<div class="card-header">
		<i class="fa fa-wrench"></i> Expense Information
	</div>
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
			{{ currency($expense->balance_amount) }}
			@slot('title')
				Balance
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