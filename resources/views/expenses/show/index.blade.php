<div class="card mb-3">
	@component('partials.card-header')
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

<div class="card mb-3">
	@component('partials.card-header')
		System Information
	@endcomponent
	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			<a href="{{ route('users.show', $expense->owner->id) }}">
				{{ $expense->owner->name }}
			</a>
			@slot('title')
				Created By
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ date_formatted($expense->created_at) }}
			@slot('title')
				Registered
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ date_formatted($expense->updated_at) }}
			@slot('title')
				Updated
			@endslot
		@endcomponent
	</ul>
</div>