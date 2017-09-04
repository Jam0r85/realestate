<div class="btn-group">
	<button class="btn btn-secondary dropdown-toggle" type="button" id="userOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Options
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userOptionsDropdown">
		<a class="dropdown-item" href="{{ route('users.show', [$user->id, 'edit-details']) }}">
			Edit Personal Details
		</a>
		<a class="dropdown-item" href="{{ route('users.show', [$user->id, 'update-email']) }}">
			Update E-Mail Address
		</a>
		<a class="dropdown-item" href="{{ route('users.show', [$user->id, 'home-address']) }}">
			Set Home Address
		</a>
		<a class="dropdown-item" href="{{ route('users.show', [$user->id, 'change-password']) }}">
			Change Password
		</a>
		<a class="dropdown-item" href="{{ route('users.show', [$user->id, 'send-email']) }}">
			Send E-Mail
		</a>
	</div>
</div>

<div class="btn-group">
	<button class="btn btn-danger dropdown-toggle" type="button" id="userActionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Actions
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userActionsDropdown">
		<a class="dropdown-item" href="{{ route('users.show', [$user->id, 'archive-user']) }}">
			Archive User
		</a>
	</div>
</div>