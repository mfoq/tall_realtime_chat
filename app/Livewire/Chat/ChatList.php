<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use Livewire\Component;

class ChatList extends Component
{
    public $selectedConversation;
    public $query;

    protected $listeners = ['chat-list:refresh' => '$refresh'];

    public function deleteByUser($id)
    {
        #get current user id
        $userId = auth()->id();

        #get converstaion that use want to delete
        $conversation = Conversation::find(decrypt($id));

        #loop through the messages to mark them as delete by (sender/receiver)
        $conversation->messages->each(function($msg) use ($userId){
            
            #delete it as sender in if or in else delete it as receiver (it depends on who owned the message)
            if($msg->sender_id === $userId){
                $msg->update(['sender_deleted_at' => now()]);
            }else{
                $msg->update(['receiver_deleted_at' => now()]);
            }
        });

        /**
         * exist 
         * 
         * All records match → true
         * Some records match, others don't → true (if at least one matches)
         * None of the records match → false
         * 
         * Does it check all records? Yes, but it stops once it finds the first matching record.
         */
        #check if the messages are deleted form both sides(receiver and sender) to force conversation deletion
        $receiverAlsoDeleted = $conversation->messages()
            ->where(function($q) use($userId){
                $q->where('sender_id', $userId)
                    ->orWhere('receiver_id', $userId);
            })->where(function($q){
                $q->whereNull('sender_deleted_at')
                    ->orWhereNull('receiver_deleted_at');
            })->exists();

        if(!$receiverAlsoDeleted)
        {
            $conversation->forceDelete();
        }

        return redirect()->route('chat.index');

    }

    public function render()
    {
        $user = auth()->user();
        return view('livewire.chat.chat-list',
    [
            'conversations' => $user->conversations()->latest('updated_at')->get()
          ]);
    }
}
