<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
  public function send(Request $request)
  {
    $newMessage = new Message;
    $newMessage->recipient = $request->to;
    $newMessage->message = $request->data;
    $newMessage->save();

    return response([
      'message' => 'Message sent.'
    ], 200);
  }

  public function receive(Request $request)
  {
    if ($request->hasHeader('X-Pub-Id')) {
      $requestingPubID = $request->header('X-Pub-Id');

      // Get all messages that belong to user
      $allMessages = Message::where('recipient', $requestingPubID)->get();

      // Delete all messages that were queried
      foreach ($allMessages as $key => $message) {
        $message->delete();
      }

      return response([
        'messages' => $allMessages,
      ], 200);
    } else {
      return response([
        'messages' => "No 'X-Pub-Id' header found on request",
      ], 500);
    }
  }
}
