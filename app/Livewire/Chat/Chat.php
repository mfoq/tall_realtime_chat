<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use Livewire\Component;

class Chat extends Component
{
    public $query; //conversation id
    public $selectedConversation;

    public function mount()
    {
        $this->selectedConversation = Conversation::findOrFail($this->query);
    }

    public function render()
    {
        return view('livewire.chat.chat');
    }
}
