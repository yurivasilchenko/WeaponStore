<?php

namespace App\Http\Controllers;

use App\Events\PusherBroadcast;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PusherController extends Controller
{


    public function index()
    {

    }


    public function broadcast(Request $request)
    {
        $senderId = Auth::id(); // Get the sender's ID (logged-in user)
        $adminId = \App\Models\User::where('usertype', 'admin')->value('id');

        // Get the recipient_id from the request
        $recipientId = $request->input('recipient_id');

        // If the user is an admin, ensure recipient_id is provided in the request
        if (Auth::user()->isAdmin()) {
            if (!$recipientId) {
                return response()->json(['error' => 'Recipient ID is required'], 400);
            }
        } else {
            // If not an admin, set recipient_id to adminId
            $recipientId = $adminId;
        }

        // Validate the recipient_id
        if (!is_numeric($recipientId)) {
            return response()->json(['error' => 'Invalid recipient ID'], 400);
        }

        // Save the message to the database
        $message = Message::create([
            'sender_id' => $senderId,
            'recipient_id' => $recipientId, // Dynamically set recipient ID
            'message' => $request->input('message'),

        ]);

        // Broadcast the message
        broadcast(new PusherBroadcast($message))->toOthers();

        return view('components.broadcast-message', ['message' => $message]);
    }





    public function receive(Request $request)
    {
        // Decode the JSON message
        $message = json_decode($request->get('message'), true);

        return view('components.receive-message', ['message' => $message]);
    }

}
