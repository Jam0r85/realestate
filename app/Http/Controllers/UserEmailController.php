<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserEmailUpdateRequest;

class UserEmailController extends BaseController
{
	/**
	 * The eloquent model for this controller.
	 * 
	 * @var string
	 */
	protected $model = 'App\User';

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UserEmailUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserEmailUpdateRequest $request, $id)
    {
    	$user = $this->repository
            ->withTrashed()
            ->findOrFail($id)
            ->fill(['email' => $request->email])
            ->saveWithMessage('email was updated');

    	return back();
    }
}
