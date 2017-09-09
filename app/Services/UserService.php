<?php

namespace App\Services;

use App\User;

class UserService
{
	public function removeUserEmail(User $user)
	{
		// User is the primary user, cannot remove their e-mail
		if ($user->id == 1) {
			abort('403', 'You cannot remove the e-mail address for the primary user');
		}

		$user->email = null;
		$user->save();
	}
}