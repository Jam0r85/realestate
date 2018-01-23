@component('partials.card')
	@slot('header')
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