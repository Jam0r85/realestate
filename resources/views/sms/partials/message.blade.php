@component('partials.card')
	@slot('header')
		<div class="float-right">
			<input type="checkbox" value="sms_print_ids[]" value="{{ $message->id }}" />
		</div>

		@if ($message->inbound == 1)
			@icon('received') from {{ $message->phone_number }}
			@if ($message->recipient)
				<span class="badge badge-secondary">
					{{ $message->recipient->present()->fullName }}
				</span>
			@endif
		@else
			@icon('sent') to {{ $message->phone_number }}
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
			<small>
				{{ $message->status() }}
			</small>
		</div>
	@endslot
@endcomponent