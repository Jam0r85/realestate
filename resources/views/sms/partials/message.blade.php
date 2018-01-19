<div class="card mb-3 {{ $message->isInbound() ? 'border' : 'text-white bg' }}-{{ $message->status('class') }}">

	@component('partials.card-header')
		{{ $message->phone_number }}

		@if ($message->recipient)
			- 
			<a href="{{ route('users.show', $message->recipient_id) }}">
				{{ $message->recipient->present()->fullName }}
			</a>
		@endif

		@slot('small')
			{{ $message->present()->timeSince('created_at') }}
		@endslot
	@endcomponent

	<div class="card-body">

		<p class="card-text">
			{{ $message->body }}
		</p>

		@if ($message->owner)
			<p class="card-text text-muted">
				<small>
					<b>{{ $message->status() }}</b> by <a href="{{ route('users.show', $message->owner_id) }}">{{ $message->owner->present()->fullName }}</a>
				</small>
			</p>
		@endif
		
	</div>

</div>