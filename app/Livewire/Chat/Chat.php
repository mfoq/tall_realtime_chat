<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use Livewire\Component;
use App\Models\Conversation;

class Chat extends Component
{
    public $query; //conversation id
    public $selectedConversation;

    public function mount()
    {
        $this->selectedConversation = Conversation::findOrFail($this->query);

        #mark messages beloging to receiver as read
        Message::where('conversation_id', $this->selectedConversation->id)
            ->where('receiver_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at'=>now()]);
    }

    public function render()
    {
        return view('livewire.chat.chat');
    }
}
