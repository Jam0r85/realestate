<div class="modal fade" id="userSendSmsMessage" tabindex="-1" role="dialog" aria-labelledby="userSendSmsMessageLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form method="POST" action="{{ route('sms.user', $user->id) }}">
			{{ csrf_field() }}
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="userSendSmsMessageLabel">Send SMS Message</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					@if (!$user->phone_number)

						@component('partials.alerts.warning')
							User has no valid mobile phone number.
						@endcomponent

					@else

						<div class="form-group">
							<label for="phone_number">Number</label>
							<input type="hidden" name="phone_number" value="{{ $user->phone_number }}">
							<input type="text" name="phone_number_show" id="phone_number_show" disabled class="form-control" value="{{ $user->phone_number }}" />
						</div>

						<div class="form-group">
							<label for="message">Message</label>
							<textarea name="message" id="message" required class="form-control" rows="8"></textarea>
						</div>

					@endif

				</div>
				@if ($user->phone_number)
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						@component('partials.save-button')
							Send Message
						@endcomponent
					</div>
				@endif
			</div>
		</form>
	</div>
</div>