<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use Livewire\Component;

class ChatBox extends Component
{
    public $selectedConversation;
    public $body;
    public $loadedMessages;

    public function mount()
    {
        $this->loadedMessages();
    }

    public function loadedMessages()
    {
        $this->loadedMessages = Message::where('conversation_id', $this->selectedConversation->id)
        ->get();
    }

    public function sendMessage()
    {
        $this->validate([
            'body' => 'required|string'
        ]);

        $createdMessage = Message::create([
            'conversation_id' => $this->selectedConversation->id,
            'sender_id' => auth()->id(),
            'receiver_id' => $this->selectedConversation->getReceiver()->id,
            'body' => $this->body,
        ]);

        $this->reset(['body']);

        $this->dispatch('scroll-bottom'); //هاي الكستوم ايفنت اللي انا ضفتها بالالباين بالاليمينت

        #push the message to the chat after safe it
        $this->loadedMessages->push($createdMessage);

        // dd($createdMessage);
    }

    public function render()
    {
        return view('livewire.chat.chat-box');
    }
}
