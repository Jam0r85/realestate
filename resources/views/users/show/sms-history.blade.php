@foreach ($user->sms as $message)
	@include('sms.partials.sms-message')
@endforeach