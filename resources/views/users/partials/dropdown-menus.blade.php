<div class="btn-group">
	<button class="btn btn-secondary dropdown-toggle" type="button" id="userOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Options
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userOptionsDropdown">
		<a class="dropdown-item" href="{{ route('users.show', [$user->id, 'update-settings']) }}">
			Update Settings
		</a>
		<a class="dropdown-item" href="{{ route('users.show', [$user->id, 'edit-details']) }}">
			Update Personal Details
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
		<div class="dropdown-divider"></div>
		<a class="dropdown-item" href="{{ route('users.show', [$user->id, 'archive-user']) }}">
			Archive User
		</a>
	</div>
</div>