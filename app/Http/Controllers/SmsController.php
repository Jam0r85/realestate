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
     * The webhook for Nexmo to receive delivery statuses.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function deliveryStatus(Request $request)
    {
    	Log::info('SMS delivery receipt request..');
    	Log::info($request->input());

		if (!isset($request->messageId) OR !isset($request->status)) {
			Log::error('Invalid delivery receipt');
		    return;
		}

    	// Loop for all main SMS messages with the given phone number.
		$entries = SmsHistory::where('phone_number', $request->msisdn)->get();

		// Loop through each of the SMS message to that number.
		foreach ($entries as $item) {

			$updated = false;
			$messages = $item->messages;

			// Loop through each of the message parts sent for the main message.
			foreach ($messages as $key => $message) {

				// Save the messageId to a variable
				if (isset($message['message-id'])) {
					$messageId = $message['message-id'];
				} elseif (isset($message['messageId'])) {
					$messageId = $message['messageId'];
				}

				// Check whether the given messageID matches the one stored in the messages array field.
				if ($messageId == $request->messageId) {

					// Remove the current message
					array_pull($messages, $key);

					// Add the new message
					$messages = array_add($messages, $key, $request->input());

					// We have updated the message
					$updated = true;
				}
			}

			if ($updated == true) {
				// Save the changes
				$item->update(['messages' => $messages]);
				Log::info('Successfuly delivery receipt for SMS ' . $item->id);
			}
		}

		return response($request->input(), 200);
	}

	/**
	 * Handle incoming messages
	 * 
	 * @param  \Illuminate\Http\Request  $request
	 * @return  \Illuminate\Http\Response
	 */
	public function incoming(Request $request)
	{

		return response($request->input(), 200);

	}
}