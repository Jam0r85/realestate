<?php

namespace App\Repositories;

use App\Mail\SendUserEmail;
use App\Mail\UserWelcomeEmail;
use App\User;
use Illuminate\Support\Facades\Mail;

class EloquentUsersRepository extends EloquentBaseRepository
{
	/**
	 * Get the class name.
	 * 
	 * @return string
	 */
	public function getClassPath()
	{
		return 'App\User';
	}

	/**
	 * Create a new user.
	 * 
	 * @param  array  $data
	 * @return user
	 */
	public function createUser(array $data)
	{
		// Create a password for the user.
		$password = str_random(10);
		$data['password'] = bcrypt($password);

		// Create and store the user.
		$user = $this->create($data);

		// Send the welcome email to the user.
		Mail::to($user)->send(new UserWelcomeEmail($password));

		return $user;
	}

	/**
	 * Update the user.
	 * 
	 * @param  array  $data
	 * @param  mixed  $model
	 * @return user
	 */
	public function updateUser(array $data, $model)
	{		
		$user = $this->update($data, $model);

		return $user;
	}

	/**
	 * Update the user's email.
	 * 
	 * @param  	string 	$email
	 * @param  	mixed 	$model
	 * @return mixed
	 */
	public function updateEmail($email, $model)
	{
		$user = $this->find($model);
		$user->email = $email;
		$user->save();

		$this->successMessage('The user\'s e-mail was updated');

		return $user;
	}

	/**
	 * Update the user's phone numbers.
	 * 
	 * @param  	string 	$email
	 * @param  	mixed 	$model
	 * @return mixed
	 */
	public function updatePhone(array $data, $model)
	{
		$user = $this->find($model);
		$user->fill($data);
		$user->save();

		$this->successMessage('The user\'s phone numbers was updated');

		return $user;
	}

	/**
	 * Update the user's password.
	 * 
	 * @param  	string 	$email
	 * @param  	mixed 	$model
	 * @return 	mixed
	 */
	public function updatePassword($password, $model)
	{
		$user = $this->find($model);
		$user->password = bcrypt($password);
		$user->save();

		$this->successMessage('The user\'s password was updated');

		return $user;
	}

	/**
	 * Update the user's groups which they are assigned to.
	 * 
	 * @param  	array 	$groups
	 * @param  	mixed 	$model
	 * @return 	mixed
	 */
	public function syncUserGroups($groups, $model)
	{
		$user = $this->find($model);
		$user->groups()->sync($groups);

		$this->successMessage('The user\'s groups were updated');

		return $user;
	}

	/**
	 * Update the user's groups which they are assigned to.
	 * 
	 * @param  	array 	$groups
	 * @param  	mixed 	$model
	 * @return 	mixed
	 */
	public function syncUserRoles($roles, $model)
	{
		$user = $this->find($model);
		$user->roles()->sync($roles);

		$this->successMessage('The user\'s roles were updated');

		return $user;
	}

	/**
	 * Update the user's home address.
	 * 
	 * @param  	array 	$groups
	 * @param  	mixed 	$model
	 * @return 	mixed
	 */
	public function updateHomeAddress($property_id, $model)
	{
		$user = $this->find($model);
		$user->update(['property_id' => $property_id]);

		$this->successMessage('The user\'s home address was updated');

		return $user;
	}

	/**
	 * Send the user an email message.
	 * 
	 * @param  array $data
	 * @param  \App\User $id
	 * @return \App\User
	 */
	public function sendEmail($data, $id)
	{
		$user = $this->find($id);

		if (!$user->email) {
			return $this->warningMessage('User does not have a valid e-mail address');
		}

		if ($data['email'] != $user->email) {
			
		}

		Mail::to($user)->send(
			new SendUserEmail($data['subject'], $data['message'], $data['attachments'], $user)
		);

		$this->successMessage('The email was sent');

		return $user;
	}
}