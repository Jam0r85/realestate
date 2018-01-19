@component('partials.card')
	@slot('card-header')
		@if ($message->isInbound())
			@icon('received') <b>received</b> from {{ $message->phone_number }}
			@if ($message->recipient)
				{{ $message->recipient()->present()->fullName }}
			@endif
		@else
			@icon('sent') <b>sent</b> to {{ $message->phone_number }}
			<span class="badge badge-secondary">
				{{ $message->recipient->present()->fullName }}
			</span>
		@endif
	@endslot
	@slot('body')
		<div class="flex-column align-items-start">
			<small>
				{{ $message->present()->timeSince('created_at') }}
			</small>
			<p class="card-text mb-1">
				{{ $message->body }}
			</p>
			<small>{{ $message->status() }}</small>
		</div>
	@endslot
@endcomponent