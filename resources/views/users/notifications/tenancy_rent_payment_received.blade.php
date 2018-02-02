@component('partials.card')
	@slot('footer')
		{{ datetime_formatted($notification->created_at) }}
	@endslot
	@slot('body')
		Rent payment of <b>{{ $notification->data['amount'] }}</b> received by {{ $notification->data['method'] }}
	@endslot
@endcomponent