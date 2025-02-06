<?php

namespace App\Models;

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

    //method to retrieve the receiver if its the auth user or another user
    public function getReceiver()
    {
        if($this->sender_id === auth()->id())
        {
            return User::firstWhere('id', $this->receiver_id);
        }else{
            return User::firstWhere('id', $this->sender_id);
        }
    }
}
