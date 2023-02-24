<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;


class MessageController extends Controller
{
  public function send(Request $request)
  {
    $request->validate([
      'to' => ['required'],
      'data' => ['required'],
    ]);

    try {
      $newMessage = new Message;
      $newMessage->recipient = $request->to;
      $newMessage->message = $request->data;
      $newMessage->save();

      return response([
        'message' => 'Message sent.'
      ], 200);
    } catch (\exception $e) {
      Log::error($e);
      return response([
        'message' => 'Error.',
      ], 500);
    }
  }

  public function receive(Request $request)
  {
    try {
      $requestingPubID = $request['user_pubkey']; // user_pubkey

      // Get all messages that belong to user
      $allMessages = Message::where('recipient', $requestingPubID)->get();

      // Delete all messages that were queried
      foreach ($allMessages as $key => $message) {
        $message->delete();
      }

      return response([
        'messages' => $allMessages,
        'pid' => $requestingPubID
      ], 200);
    } catch (\exception $e) {
      Log::error($e);
      return response([
        'message' => 'Error.',
      ], 500);
    }
  }
}
