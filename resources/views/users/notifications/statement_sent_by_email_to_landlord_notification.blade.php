@component('partials.card')
	@slot('footer')
		{{ datetime_formatted($notification->created_at) }}
	@endslot
	@slot('body')
		<a href="{{ route('statements.show', $notification->data['statement_id']) }}">
			Statement <b>{{ $notification->data['statement_id'] }}</b>
		</a> was sent by e-mail to the landlord.
	@endslot
@endcomponent