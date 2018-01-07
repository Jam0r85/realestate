<div class="card mb-3 {{ $message->isInbound() ? 'border' : 'text-white bg' }}-{{ $message->status('class') }}">

	@component('partials.card-header')
		{{ $message->phone_number }}

		@if ($message->user)
			- 
			<a href="{{ route('users.show', $message->user_id) }}">
				{{ $message->user->present()->fullName }}
			</a>
		@endif

		@slot('small')
			{{ datetime_formatted($message->created_at) }}
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