<div class="modal fade" id="userSendEmailModal" tabindex="-1" role="dialog" aria-labelledby="userSendEmailModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form role="form" method="POST" action="{{ route('users.send-email', $user->id) }}">
			{{ csrf_field() }}
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="userSendEmailModalLabel">Send E-Mail</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

					@if (!$user->email)

						@component('partials.alerts.warning')
							User has no valid e-mail address.
						@endcomponent

					@else

						<div class="form-group">
							<label for="email">E-Mail</label>
							<input type="text" name="email" id="email" class="form-control" disabled value="{{ $user->email }}" />
						</div>	

						<div class="form-group">
							<label for="subject">Subject</label>
							<input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject') }}" />
							<small class="form-text text-muted">
								The subject of the e-mail and the e-mail header.
							</small>
						</div>	

						<div class="form-group">
							<label for="message">Message</label>
							<textarea name="message" id="message" rows="12" class="form-control">{{ old('message') }}</textarea>
						</div>

					@endif

				</div>
				@if ($user->email)
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						@component('partials.save-button')
							Send E-Mail
						@endcomponent
					</div>
				@endif
			</div>
		</form>
	</div>
</div>