@component('partials.card')
	@slot('style')
		@if ($note->user->isStaff())
			border-primary
		@endif
	@endslot
	@slot('header')
		@if ($note->user->isStaff())
			<span class="badge badge-primary float-right">
				Staff
			</span>
		@endif
		{{ $note->present()->dateTimeCreated }}
	@endslot
	@slot('body')
		<p class="card-text">
			{{ $note->body }}
		</p>
		<small class="text-muted">
			By {{ $note->user->present()->fullName }}
		</small>
	@endslot
@endcomponent