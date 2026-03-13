<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class PendingChat extends Component
{
    use WithFileUploads;


    public function render()
    {
        $messages = Message::where('status',0)->paginate();
       
        return view('livewire.pending-chat',compact('messages'));
    }
    
    public function approved($id){
            
        $message =  Message::find($id);
        $message->status = 1 ;
        $message->save();
           
    }
   
     public function delete($id){
            
          $message =  Message::find($id);
          if($message){
              $message->delete();
          }
            
    }
}
