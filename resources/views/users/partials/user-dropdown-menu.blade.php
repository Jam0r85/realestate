<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#userSendSmsMessage">
	<i class="fa fa-comment"></i> Send SMS
</button>

<a href="{{ route('users.show', [$user->id, 'send-email']) }}" class="btn btn-primary">
	<i class="fa fa-envelope"></i> Send E-Mail
</a>

<div class="btn-group">
	<button class="btn btn-secondary dropdown-toggle" type="button" id="userOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<i class="fa fa-cogs"></i> Options
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userOptionsDropdown">
		<a class="dropdown-item" href="{{ route('users.show', [$user->id, 'user-settings']) }}">
			Change Settings
		</a>
		<a class="dropdown-item" href="{{ route('users.show', [$user->id, 'user-details']) }}">
			Update Details
		</a>
		<a class="dropdown-item" href="{{ route('users.show', [$user->id, 'update-email']) }}">
			Change E-Mail Address
		</a>
		<a class="dropdown-item" href="{{ route('users.show', [$user->id, 'change-password']) }}">
			Change Password
		</a>
	</div>
</div>