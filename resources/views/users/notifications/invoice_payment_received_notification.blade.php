@component('partials.card')
	@slot('footer')
		{{ datetime_formatted($notification->created_at) }}
	@endslot
	@slot('body')
		Payment of <b>{{ $notification->data['amount'] }}</b> received by {{ $notification->data['method'] }} for <b>{{ $notification->data['invoice'] }}</b>.
	@endslot
@endcomponent