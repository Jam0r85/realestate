<div class="card mb-3">

	@component('partials.card-header')
		Bank Account Information
	@endcomponent

	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{{ $account->bank_name }}
			@slot('title')
				Bank Name
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ $account->account_name }}
			@slot('title')
				Account Name
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ $account->sort_code }}
			@slot('title')
				Sort Code
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ $account->account_number }}
			@slot('title')
				Account Number
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
			{{ $account->owner->present()->fullName }}
			@slot('title')
				Created By
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ date_formatted($account->created_at) }}
			@slot('title')
				Registered
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ date_formatted($account->updated_at) }}
			@slot('title')
				Updated
			@endslot
		@endcomponent
	</ul>
</div>