<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserSendSmsMessageRequest;
use App\Notifications\UserSmsMessage;
use App\SmsHistory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;

class SmsController extends BaseController
{
	/**
	 * Display a list of sent SMS messages.
	 * 
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$messages = SmsHistory::with('recipient','owner')->latest()->paginate();
		return view('sms.index', compact('messages'));
	}

	/**
	 * Send an SMS message to the given user.
	 *
	 * @param \App\Http\Requests\UserSendSmsMessageRequest $request
	 * @param \App\User $user
	 * @return \Illuminate\Http\Response
	 */
    public function toUser(UserSendSmsMessageRequest $request, User $user)
    {
    	$response = $user->notify(new UserSmsMessage($request->message));

    	$this->successMessage('The SMS was sent to ' . $user->phone_number);
    	return back();
    }

    /**
     * The webhook for Nexmo to send delivery statuses to.
     * 
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function deliveryStatus()
    {
    	// Loop for all main SMS messages with the given phone number.
		$entries = SmsHistory::where('phone_number', Input::get('to'))->get();

		// Loop through each of the SMS message to that number.
		foreach ($entries as $item) {
			// Loop through each of the rsent messages for the main message.
			foreach ($item->messages as $message) {
				// Check whether the given messageID matches the one stored in the messages array field.
				if ($message['message-id'] == Input::get('messageId')) {
					// Update the status message and status.
					$message['status-message'] = Input::get('status');
					$message['status'] = Input::get('err-code');
				}
				// Save the main message itself.
				$item->save();
			}
		}

		return response('OK', 200);
	}
}