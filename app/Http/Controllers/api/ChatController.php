<?php

namespace App\Http\Controllers\api;

use App\Models\Message;
use App\Traits\ApiTrait;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Http\Resources\ConversationResource;

class ChatController extends Controller
{
    use ApiTrait;

    public function startConversation(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
        ]);

        $conversation = Conversation::firstOrCreate([
            'user1_id' => auth()->id(),
            'user2_id' => $request->receiver_id,
        ]);

        $conversation->load('user1');
        $conversation->load('user2');

        return $this->success('conversation created successfully' , 200 , new ConversationResource($conversation));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required|exists:conversations,id',
            'content' => 'required|string',
        ]);

        $message = Message::create([
            'conversation_id' => $request->conversation_id,
            'sender_id' => auth()->id(),
            'content' => $request->content,
        ]);

        $message->load('sender');

        return $this->success('message send successfully' , 200 , new MessageResource($message));

    }

    public function getUserConversations()
    {
        $userId = auth()->id();

        $conversations = Conversation::where('user1_id', $userId)
            ->orWhere('user2_id', $userId)
            ->with(['user1', 'user2', 'messages'])
            ->get()
            ->map(function ($conversation) use ($userId) {
                // تحديد الطرف الآخر في المحادثة
                $otherUser = ($conversation->user1_id == $userId) ? $conversation->user2 : $conversation->user1;

                return [
                    'conversation_id' => $conversation->id,
                    'other_user' => [
                        'id' => $otherUser->id,
                        'name' => $otherUser->name,
                        'image' => $otherUser->image,
                    ],
                    'last_message' => $conversation->messages->last(),
                ];
            });

        return $this->success('All Coversation' , 200 , $conversations);
    }

    // 🔹 جلب رسائل محادثة معينة
    public function getMessages($conversation_id)
    {
        $messages = Message::where('conversation_id', $conversation_id)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        return $this->success('messages' , 200 , MessageResource::collection($messages));
    }

}
