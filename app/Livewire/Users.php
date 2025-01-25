<?php

namespace App\Livewire;

use App\Models\Conversation;
use App\Models\User;
use Livewire\Component;

class Users extends Component
{

    public function message($userId)
    {
        $authenticatedUserId = auth()->id();

        #check conversation exists an redirect to it
        $existsingConversation = Conversation::where(function($query) use($authenticatedUserId, $userId){
                $query->where('sender_id', $authenticatedUserId)
                    ->where('receiver_id', $userId);
        })->orWhere(function($query) use($authenticatedUserId, $userId){
            $query->where('receiver_id', $authenticatedUserId)
                    ->where('sender_id', $userId);
        })->first();

        if($existsingConversation)
        {
            return redirect()->route('chat', ['query' => $existsingConversation->id]);
        }

        #create conversation
        $createdConveration = Conversation::create([
            'sender_id' => $authenticatedUserId,
            'receiver_id' => $userId
        ]);

        return redirect()->route('chat', ['query' => $createdConveration->id]);

    }
    public function render()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('livewire.users', ['users' => $users]);
    }
}
