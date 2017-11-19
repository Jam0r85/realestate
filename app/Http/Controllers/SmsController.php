<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserSendSmsMessageRequest;
use App\Notifications\UserSmsMessage;
use App\SmsHistory;
use App\User;
use Illuminate\Http\Request;
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
    public function deliveryStatus(Request $request)
    {
		if (!isset($request->messageId) OR !isset($request->status)) {
			Log::error('Not a valid delivery receipt');
		    return;
		}

    	// Loop for all main SMS messages with the given phone number.
		$entries = SmsHistory::where('phone_number', $request->to)->get();

		// Loop through each of the SMS message to that number.
		foreach ($entries as $item) {
			// Loop through each of the rsent messages for the main message.
			foreach ($item->messages as $key => $message) {
				// Check whether the given messageID matches the one stored in the messages array field.
				if ($message['message-id'] == $request->messageId) {
					$messages = $item->messages;
					// Remove the current message
					array_pull($messages, $key);
					// Add the new message
					$messages = array_add($messages, $key, $request->input());
					$item->messages = $messages;
					$item->save();
				}
			}
		}

		return response('OK', 200);
	}
}