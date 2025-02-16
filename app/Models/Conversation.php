<?php

namespace App\Models;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id'
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    #-------------Start Local Scopes--------------
    
    public function scopeWhereNotDeleted($query)
    {   
        $userId = auth()->id();

        return $query->where(function($q) use($userId){

            #where messages is not deleted
            $q->whereHas('messages', function($q) use($userId){

                $q->where(function($q) use($userId){

                    $q->where('sender_id', $userId)
                            ->whereNull('sender_deleted_at');
                    })->orWhere(function($q) use ($userId){
                        $q->where('receiver_id', $userId)
                            ->whereNull('receiver_deleted_at');
                    });
                    
            })
                
            #include conversations without messages
            ->orWhereDoesntHave('messages');
        });
    }

    #-------------End Local Scopes--------------

    #method to retrieve the receiver if its the auth user or another user
    public function getReceiver()
    {
        if($this->sender_id === auth()->id())
        {
            return User::firstWhere('id', $this->receiver_id);
        }else{
            return User::firstWhere('id', $this->sender_id);
        }
    }

    #mehtod to get if last message that i sent read by receiver or no
    public function isLastMessageReadByUser():bool
    {
        $user = Auth()->User();
        $lastMessage = $this->messages()->latest()->first();

        if($lastMessage)
        {
            return $lastMessage->read_at !== null && $lastMessage->sender_id == $user->id;
        }

    }


    #method to get the unread messages count
    public function unreadMessagesCount(): int
    {
        return $unreadMessages = Message::where('conversation_id', $this->id)
                                    ->where('receiver_id', auth()->id())
                                    ->whereNull('read_at')->count();
    }
}
