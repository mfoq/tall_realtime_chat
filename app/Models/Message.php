<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'body',
        'sender_id',
        'receiver_id',
        'conversation_id',
        'read_at',
        'receiver_delete_at',
        'sender_deleted_at',
    ];

    protected $dates = ['read_at','receiver_delete_at','sender_deleted_at'];

    /* relation ships */

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }


    /* Accessers */
    public function getIsReadAttribute() : bool
    {
        return $this->read_at != null;
    }
}
