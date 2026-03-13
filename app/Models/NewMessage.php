<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewMessage extends Model
{
    protected $fillable = [
        'sender_id','receiver_id','group_id','type','message','file_path', 'status'
    ];

    public function sender() {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver() {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function group() {
        return $this->belongsTo(Group::class, 'group_id');
    }
}