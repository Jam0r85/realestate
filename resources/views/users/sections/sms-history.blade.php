<div class="tab-pane fade" id="v-pills-sms-history" role="tabpanel">

	@foreach ($sms_messages as $message)
		@include('sms.partials.sms-message')
	@endforeach
	
</div>