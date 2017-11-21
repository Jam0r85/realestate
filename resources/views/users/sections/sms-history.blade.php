<div class="tab-pane fade" id="v-pills-sms-history" role="tabpanel">

	@foreach ($user->sms as $message)
		@include('sms.partials.sms-message')
	@endforeach
	
</div>