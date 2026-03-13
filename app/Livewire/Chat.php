<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class chat extends Component
{
    use WithFileUploads;
    public $message = '';
    public $messages;
    public $user;
    public $user_name;
    public $profileImage;
    public $page = 1;
    public $image ;
    protected $listeners = ['messageReceived' => 'addMessage'];

    public function mount()
    {
        $this->user = Auth::user();
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $perPage = 2;
        $this->messages = Message::with('user')
                ->where('status',1)
            ->get()
            ->groupBy(fn($message) => $message->created_at->format('Y-m-d'))->all();

        
    
  
    }
    
    public function removeImage()
{
    $this->image = null;
}

    public function sendMessage()
    {

        if(!$this->message){
            return false ;
        }

        $message = new Message();
        $message->body =$this->message ;
        $message->type = 'text' ;
        if ($this->image) {
            $filePath = $this->image->store('uploads', 'public');
            $message->type = 'file';
            $message->file = $filePath;
        }
        if ($this->profileImage) {
            $profileImage = $this->profileImage->store('uploads', 'public');
            $message->profile_image = $profileImage;
        }
        if ($this->user_name) {
            $message->user_name = $this->user_name ;
            $message->status = 1 ;
            
        }else{
            $message->user_id = $this->user->id ;
        }

        
        if(auth()->user()->role == 'super admin'){
            $message->status = 1 ;
        }
        $message->save();
       
    
       
        $this->message = '';
        $this->image = null;
        $this->loadMessages();
        $this->dispatch('messageSent', 'message sent successfully');
        
       
    }
    
    
    
    public function deletemsg($id){
            $data = Message::find($id);
            if($data){
                    $data->delete();
            }
            $this->loadMessages();
    }
    
    
    

    public function loadMoreMessages()
    {
        $this->page++;
        $this->loadMessages();
    }

    public function addMessage()
    {
        $this->loadMessages();
    }

    public function render()
    {
        return view('livewire.chat');
    }

   
}
