<div class="card mb-3">
	<div class="card-header">
		<i class="fa fa-cogs"></i> Bank Account Information
	</div>
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