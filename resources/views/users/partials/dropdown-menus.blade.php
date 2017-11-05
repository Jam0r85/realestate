<div class="btn-group">
	<button class="btn btn-secondary dropdown-toggle" type="button" id="userOptionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		Options
	</button>
	<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userOptionsDropdown">
		<a class="dropdown-item" href="{{ route('users.show', [$user->id, 'user-settings']) }}">
			User Settings
		</a>
		<a class="dropdown-item" href="{{ route('users.show', [$user->id, 'edit-details']) }}">
			Personal Details
		</a>
		<a class="dropdown-item" href="{{ route('users.show', [$user->id, 'user-status']) }}">
			User Status
		</a>
		<a class="dropdown-item" href="{{ route('users.show', [$user->id, 'update-email']) }}">
			Change E-Mail Address
		</a>
		<a class="dropdown-item" href="{{ route('users.show', [$user->id, 'home-address']) }}">
			Current Location
		</a>
		<a class="dropdown-item" href="{{ route('users.show', [$user->id, 'change-password']) }}">
			Change Password
		</a>
		<a class="dropdown-item" href="{{ route('users.show', [$user->id, 'send-email']) }}">
			Send E-Mail
		</a>
	</div>
</div>