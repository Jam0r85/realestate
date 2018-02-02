@component('partials.card')
	@slot('footer')
		{{ datetime_formatted($notification->created_at) }}
	@endslot
	@slot('body')
		Statement <a href="{{ route('statements.show', $notification->data['statement_id']) }}">
			<b>{{ $notification->data['statement_id'] }}</b>
		</a> was completed and sent by e-mail.
	@endslot
@endcomponent