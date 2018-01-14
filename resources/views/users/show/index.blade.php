<div class="card mb-3">

	@component('partials.card-header')
		@icon('address-card') User's Information
	@endcomponent

	<ul class="list-group list-group-flush">
		<li class="list-group-item flex-column">
			<div class="d-flex justify-content-between">
				<span class="text-muted">
					Title
				</span>
				{{ $user->title }}
			</div>
		</li>
		<li class="list-group-item flex-column">
			<div class="d-flex justify-content-between">
				<span class="text-muted">
					First Name
				</span>
				{{ $user->first_name }}
			</div>
		</li>
		<li class="list-group-item flex-column">
			<div class="d-flex justify-content-between">
				<span class="text-muted">
					Last Name
				</span>
				{{ $user->last_name }}
			</div>
		</li>
		<li class="list-group-item flex-column">
			<div class="d-flex justify-content-between">
				<span class="text-muted">
					Company Name
				</span>
				{{ $user->company_name }}
			</div>
		</li>
		<li class="list-group-item flex-column">
			<div class="d-flex justify-content-between">
				<span class="text-muted">
					E-Mail
				</span>
				{{ $user->email }}
			</div>
		</li>
		<li class="list-group-item flex-column">
			<div class="d-flex justify-content-between">
				<span class="text-muted">
					Mobile Phone
				</span>
				{{ $user->phone_number }}
			</div>
		</li>
		<li class="list-group-item flex-column">
			<div class="d-flex justify-content-between">
				<span class="text-muted">
					Other Phone Number
				</span>
				{{ $user->phone_number_other }}
			</div>
		</li>
	</ul>
</div>

<div class="card mb-3">

	@component('partials.card-header')
		System Information
	@endcomponent

	<ul class="list-group list-group-flush">
		@component('partials.bootstrap.list-group-item')
			{!! $user->present()->branchLink !!}
			@slot('title')
				Registered Branch
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{!! $user->present()->ownerProfileLink !!}
			@slot('title')
				Registered By
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ $user->present()->createdDate }}
			@slot('title')
				Registered
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			{{ datetime_formatted($user->updated_at) }}
			@slot('title')
				Updated
			@endslot
		@endcomponent
		@component('partials.bootstrap.list-group-item')
			@slot('title')
				Last Login
			@endslot
		@endcomponent
	</ul>
</div>