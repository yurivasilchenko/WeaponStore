<?php

namespace App\Http\Controllers;

use App\Events\PusherBroadcast;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PusherController extends Controller
{
  /*  public function index(){
        return view('user.chat');
    }

    public function broadcast(Request $request){

        broadcast(new PusherBroadcast($request->get('message')))->toOthers();

        return view('components.broadcast-message',['message' => $request->get('message')]);
    }*/

    public function index()
    {
        // Get the authenticated user's ID
        $userId = Auth::id();

        // Admin can see all messages
        if (Auth::user()->isAdmin()) {
            // Admin: retrieve all messages
            $messages = Message::with(['sender', 'recipient'])->get();
            return view('admin.chat', ['messages' => $messages]);
        } else {
            // Non-admin users: retrieve only their conversation with admin (assuming admin ID = 1)
            $messages = Message::where(function($query) use ($userId) {
                $query->where('sender_id', $userId)->orWhere('recipient_id', $userId);
            })->where(function($query) {
                $query->where('sender_id', 1)->orWhere('recipient_id', 1); // Admin's user ID is 1
            })->get();

            return view('user.chat', ['messages' => $messages]);
        }
    }

    public function broadcast(Request $request)
    {
        $senderId = Auth::id(); // Get the sender's ID (logged-in user)
        $adminId = \App\Models\User::where('usertype', 'admin')->value('id');

        // Get the recipient_id from the request
        $recipientId = \App\Models\User::where('usertype', 'user')->first()->id;

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
