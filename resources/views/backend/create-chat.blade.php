@extends('admin.layouts.app')

@php
    $pageTitle = 'Group Chat';
@endphp

@section('panel')
<div class="row">
    <div class="col-md-12">
        <form id="groupMsgForm" enctype="multipart/form-data">
            @csrf
            <div class="card mb-3 p-3">

                <div class="mb-3">
                    <label class="form-label">Profile Picture</label>
                    <input type="file" name="profile" accept="image/*" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Profile Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter profile name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Message</label>
                    <textarea name="message" class="form-control" rows="3" placeholder="Write your message..."></textarea>
                </div>

                <!-- Voice Recorder -->
                <div class="mb-3 text-center">
                    <button type="button" id="startRecord" class="btn btn-primary btn-circle mb-2">
                        <i class="fa fa-microphone"></i>
                    </button>

                    <div id="recordingUI" class="d-none">
                        <div class="d-flex justify-content-between align-items-center gap-2">
                            <div>
                                <span id="timer">00:00</span>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="button" id="cancelRecord" class="btn btn-outline-danger btn-sm">Stop</button>
                                <button type="button" id="confirmRecord" class="btn btn-success btn-sm">Ok</button>
                            </div>
                        </div>
                    </div>

                    <audio id="previewAudio" class="mt-2 w-100 d-none" controls></audio>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success">Send Message</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
let mediaRecorder, chunks = [], timerInterval, seconds = 0;
const startBtn = document.getElementById('startRecord');
const recordUI = document.getElementById('recordingUI');
const cancelBtn = document.getElementById('cancelRecord');
const confirmBtn = document.getElementById('confirmRecord');
const timerEl = document.getElementById('timer');
const preview = document.getElementById('previewAudio');

function updateTimer() {
    seconds++;
    const mins = String(Math.floor(seconds / 60)).padStart(2,'0');
    const secs = String(seconds % 60).padStart(2,'0');
    timerEl.textContent = `${mins}:${secs}`;
}

startBtn.onclick = async () => {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
        mediaRecorder = new MediaRecorder(stream);
        chunks = [];
        mediaRecorder.start();
        seconds = 0;
        timerEl.textContent = "00:00";
        timerInterval = setInterval(updateTimer, 1000);
        recordUI.classList.remove('d-none');
        startBtn.classList.add('d-none');
        mediaRecorder.ondataavailable = e => chunks.push(e.data);
    } catch (err) {
        alert('Microphone access denied');
    }
};

cancelBtn.onclick = () => {
    if(mediaRecorder && mediaRecorder.state !== 'inactive') mediaRecorder.stop();
    clearInterval(timerInterval);
    chunks = [];
    seconds = 0;
    timerEl.textContent = "00:00";
    recordUI.classList.add('d-none');
    startBtn.classList.remove('d-none');
};

confirmBtn.onclick = () => {
    if(mediaRecorder && mediaRecorder.state !== 'inactive') {
        mediaRecorder.stop();
        clearInterval(timerInterval);

        mediaRecorder.onstop = () => {
            const blob = new Blob(chunks, { type: 'audio/webm' });
            const url = URL.createObjectURL(blob);
            preview.src = url;
            preview.classList.remove('d-none');
            recordUI.classList.add('d-none');
            startBtn.classList.remove('d-none');

            const file = new File([blob], 'audio_message.webm', { type: 'audio/webm' });
            const dt = new DataTransfer();
            dt.items.add(file);
            const input = document.createElement('input');
            input.type = 'file';
            input.name = 'audio';
            input.files = dt.files;
            input.classList.add('d-none');
            document.getElementById('groupMsgForm').appendChild(input);
        };
    }
};

document.getElementById('groupMsgForm').addEventListener('submit', async function(e){
    e.preventDefault();
    const formData = new FormData(this);
    const sendBtn = this.querySelector('button[type="submit"]');
    sendBtn.disabled = true;
    sendBtn.textContent = 'Sending...';

    try {
        const res = await fetch('{{ route("admin.send.message") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        });
        const result = await res.json();
        if(result.success){
            alert('✅ Message sent successfully!');
            this.reset();
            preview.classList.add('d-none');
        } else {
            alert('❌ Failed: ' + (result.error || 'Something went wrong.'));
        }
    } catch(err){
        console.error(err);
        alert('⚠️ Network or server error.');
    } finally {
        sendBtn.disabled = false;
        sendBtn.textContent = 'Send Message';
    }
});
</script>
@endsection