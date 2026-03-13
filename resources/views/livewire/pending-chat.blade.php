<div>

    <table class="table table-stripped">
            <thead>
                <tr>
                    <td>User Name</td>
                    <td>Message</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                @if(!blank($messages) > 0)
                @foreach($messages as $message)
                    <tr>
                        <td>{{ $message->user->name }}</td>
                        <td>{{ $message->body }}</td>
                        <td> <button class="btn btn-success" wire:click="approved({{ $message->id }})">Approve</button>  <button class="btn btn-danger" wire:click="delete({{ $message->id }})">Delete</button> </td>
                    </tr>
                @endforeach
                @endif
            </tbody>
    </table>
    {!! $messages->links('livewire::bootstrap') !!}
   
</div>

@push('scripts')
   
@endpush
