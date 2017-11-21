<div class="tab-pane fade @if (request('section') == 'details' || (!request('section') && $loop->first)) show active @endif" id="v-pills-details" role="tabpanel">

	<div class="card mb-3">

		@component('partials.card-header')
			User's Information
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
			Current Location
			<small class="d-block text-muted">
				Where the user currently lives.
			</small>
		@endcomponent

		<div class="card-body">

			{{ $user->present()->location('full') }}

		</div>
	</div>

	<div class="card mb-3">

		@component('partials.card-header')
			System Information
		@endcomponent

		<ul class="list-group list-group-flush">
			@component('partials.bootstrap.list-group-item')
				{{ $user->branch ? $user->branch->name : '-' }}
				@slot('title')
					Registered Branch
				@endslot
			@endcomponent
			@component('partials.bootstrap.list-group-item')
				<a href="{{ route('users.show', $user->owner->id) }}">
					{{ $user->owner->present()->fullName }}
				</a>
				@slot('title')
					Created By
				@endslot
			@endcomponent
			@component('partials.bootstrap.list-group-item')
				{{ date_formatted($user->created_at) }}
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

</div>