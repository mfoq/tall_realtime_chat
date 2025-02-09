<?php

namespace App\Livewire\Chat;

use App\Models\Message;
use Livewire\Component;
use App\Notifications\MessageSent;

class ChatBox extends Component
{
    public $selectedConversation;
    public $body;
    public $loadedMessages;
    public $pagination_var = 10;#هاي ضفتها عشان بدي اعمل باجينيشن للمسجات عشان البيرفورمانس

    protected $listeners = ['loadMore'];

    public function mount()
    {
        $this->loadedMessages();
    }

    #used to load more messages (paginations)
    public function loadMore() : void
    {
        #increment
        $this->pagination_var += 10;

        #call load messages
        $this->loadedMessages();

        #update the chat height
        $this->dispatch('update-chat-height');

    }

    public function loadedMessages()
    {
        #get count 
        $count = Message::where('conversation_id', $this->selectedConversation->id)->count();

        #skip and query
        $this->loadedMessages = Message::where('conversation_id', $this->selectedConversation->id)
            ->skip($count - $this->pagination_var)
            ->take($this->pagination_var)
            ->get();

        return $this->loadedMessages;
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

        #update the conversation (update_at) model to be current data
        $this->selectedConversation->updated_at = now();
        $this->selectedConversation->save();

        #refresh chatList
        $this->dispatch('chat-list:refresh');

        #broadcast
        $this->selectedConversation->getReceiver()
            ->notify(new MessageSent(
                auth()->user(),
                $createdMessage,
                $this->selectedConversation,
                $this->selectedConversation->getReceiver()->id
            ));
    }

    public function render()
    {
        return view('livewire.chat.chat-box');
    }
}
