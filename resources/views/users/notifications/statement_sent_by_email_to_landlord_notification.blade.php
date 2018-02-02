@component('partials.card')
	@slot('footer')
		{{ datetime_formatted($notification->created_at) }}
	@endslot
	@slot('body')
		Statement {{ $notification->data['statement_id'] }} was sent by E-Mail to the Landlord.
	@endslot
@endcomponent