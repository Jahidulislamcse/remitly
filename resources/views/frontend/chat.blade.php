@extends('frontend.layout.master')

@section('style')
    <style>
       iframe {
            background: #1f1f1f;
            border-radius: 1px;
        }
    </style>
@endsection

@section('content')
<div class="w-full max-w-[420px] sm:mx-auto min-h-screen bg-background-light dark:bg-background-dark text-[#1A1A1A] dark:text-white flex flex-col">

    
    <!-- Chat list wrapper -->
    <div id="chatWrapper" class="flex-1 flex flex-col">
        <div id="chatListView" class="flex-1 flex flex-col">

            <!-- Top: Stories + Active users -->
            <div class="flex gap-4 px-4 py-3 overflow-x-auto scrollbar-hide border-b border-zinc-300">

                <a href="{{ route('user.index') }}">
                    <div class="flex items-center justify-center w-10 h-20 rounded-full hover:bg-gray-100 dark:hover:bg-white/10 cursor-pointer">
                        <span class="material-symbols-outlined text-black dark:text-white">
                            arrow_back_ios_new
                        </span>
                    </div>
                </a>

                <!-- Active users -->
                @foreach($activeUsers as $user)
                    @php $img = preg_match('/^data:image/', $user->image) ? $user->image : asset($user->image); @endphp
                    <div onclick="selectUser('{{ $user->id }}','{{ $user->name }}','{{ $img }}')" 
                        class="flex flex-col items-center text-xs cursor-pointer relative">
                        <img src="{{ $img }}" class="w-14 h-14 rounded-full object-cover border-2 border-primary">
                        @if($user->is_online)
                            <span class="absolute bottom-0 right-1 w-3 h-3 bg-green-500 rounded-full border-2 border-background-dark"></span>
                        @endif
                        <span class="mt-1">{{ $user->name }}</span>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-between items-center px-4 py-3 border-b border-zinc-300">
                <h2 class="font-semibold">Chats</h2>

                <button onclick="openGroupModal()" 
                    class="bg-primary text-white px-3 py-1 rounded text-sm">
                    + Group
                </button>
            </div>

            <!-- Chat list -->
            <div id="chatList" class="flex-1 overflow-y-auto">
               @foreach($recentChats as $chat)
                    @php 
                        $user = $chat->otherUser;
                        if (!$user) continue; 
                        $img = preg_match('/^data:image/', $user->image) ? $user->image : asset($user->image);
                    @endphp
                    <div id="chatItem-{{ $user->id }}" onclick="selectUser('{{ $user->id }}','{{ $user->name }}','{{ $img }}')"
                        class="flex items-center gap-3 px-4 py-3 cursor-pointer hover:bg-zinc-200 border-b border-zinc-300">
                        <div class="relative">
                            <img src="{{ $img }}" class="w-12 h-12 rounded-full object-cover">
                            @if($user->is_online)
                                <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-background-dark"></span>
                            @endif
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold">{{ $user->name }}</span>
                                <span class="text-xs text-gray-400">{{ $chat->last_message_time->format('g:i A') }}</span>
                            </div>
                            <p class="text-sm text-gray-400 truncate">{{ $chat->last_message_preview }}</p>
                        </div>
                    </div>
                @endforeach

                <!-- Groups -->
                @if(!empty($groups))
                    <div class="px-4 py-2 font-semibold text-gray-500">Groups</div>
                    @foreach($groups as $group)
                        <div id="chatItem-group-{{ $group->id }}" 
                            onclick="selectGroup('{{ $group->id }}','{{ $group->name }}')" 
                            class="flex items-center gap-3 px-4 py-3 cursor-pointer hover:bg-zinc-200 border-b border-zinc-300">
                            <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($group->name,0,2)) }}
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <span class="font-semibold">{{ $group->name }}</span>
                                    <span class="text-xs text-gray-400">{{ $group->last_message_time->format('g:i A') }}</span>
                                </div>
                                <p class="text-sm text-gray-400 truncate">{{ $group->last_message_preview }}</p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    <!-- Chat box view -->
    <div id="chatBoxView" class="flex-1 flex flex-col hidden">
        <header id="chatHeader" class="sticky top-0 z-50 glass-header border-b border-zinc-200 dark:border-zinc-300 px-4 py-4 flex items-center gap-2">
            <button id="backToList" class="w-8 h-8 flex items-center justify-center text-white">
                <span class="material-symbols-outlined">arrow_back_ios_new</span>
            </button>
            <span id="chatHeaderTitle" class="font-bold">Select a chat</span>
        </header>

        <div id="chatBox" style="margin-top: 100px;" class="flex-1 overflow-y-auto px-4 py-6 space-y-3 scrollbar-hide bg-background-light dark:bg-background-dark"></div>

        <div class="sticky bg-background-light dark:bg-background-dark border-t border-zinc-200 dark:border-zinc-300 px-4 py-3 flex items-center gap-2">
            <!-- Emoji Button -->
            <button type="button" id="emojiBtn" class="text-gray-400">
                <span class="material-symbols-outlined">mood</span>
            </button>

            <!-- Sticker Button -->
            <button type="button" id="stickerBtn" class="text-gray-400">
                <span class="material-symbols-outlined">gif_box</span>
            </button>

            <!-- File Input Hidden -->
            <input type="file" id="fileInput" name="file" accept="image/*,audio/*,.pdf,.doc,.docx" class="hidden">
            <button type="button" onclick="document.getElementById('fileInput').click()" class="text-gray-400">
                <span class="material-symbols-outlined">attach_file</span>
            </button>

            <!-- Message Input -->
            <input type="text" id="messageInput" placeholder="Type message..."
                class="flex-1 h-12 bg-gray-100 dark:bg-zinc-900 border border-zinc-300 dark:border-zinc-300 rounded-full px-4 text-sm text-[#1A1A1A] dark:text-white focus:outline-none focus:border-primary">

            <!-- Send Button -->
            <button onclick="sendMessage()" 
                class="w-12 h-12 rounded-full bg-gradient-to-r from-primary to-[#b80a0a] flex items-center justify-center shadow-lg">
                <span class="material-symbols-outlined text-white">send</span>
            </button>

        </div>

            <!-- Emoji Picker -->
        <div id="emojiPicker" class="hidden"></div>

        <!-- Sticker Panel -->
        <div id="stickerPanel" class="hidden bg-gray-100 dark:bg-zinc-900 border-t border-zinc-300 dark:border-zinc-300 p-3">
            <input type="text" id="stickerSearch" placeholder="Search GIF..." class="w-full bg-zinc-800 p-2 rounded mb-2 text-sm">
            <div id="stickerResults" class="grid grid-cols-3 gap-2 max-h-60 overflow-y-auto"></div>
        </div>
    </div>
    
    <div id="groupModal" class="fixed inset-0 bg-black/60 hidden flex items-center justify-center z-50">
    
        <div class="bg-white dark:bg-zinc-900 w-[350px] rounded-xl p-4">

            <h2 class="text-lg font-semibold mb-3">Create Group</h2>

            <!-- Group Name -->
            <input type="text" id="groupName"
                placeholder="Group Name"
                class="w-full border p-2 rounded mb-3">

            <!-- User List -->
            <div class="max-h-60 overflow-y-auto space-y-2">

                @foreach($activeUsers as $user)
                <label class="flex items-center gap-2 cursor-pointer">

                    <input type="checkbox" value="{{ $user->id }}" class="groupUser">

                    <span>{{ $user->name }}</span>

                </label>
                @endforeach

            </div>

            <div class="flex justify-end gap-2 mt-4">

                <button onclick="closeGroupModal()" class="px-3 py-1 bg-gray-400 text-white rounded">
                    Cancel
                </button>

                <button onclick="createGroup()" class="px-3 py-1 bg-green-600 text-white rounded">
                    Create
                </button>

            </div>

        </div>

    </div>
</div>

@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        let receiverId = null;
        let lastMessageId = null;
        let currentGroupId = null;
        const AUTH_ID = {{ auth()->id() }};

        const chatBox = document.getElementById('chatBox');
        const chatHeaderTitle = document.getElementById('chatHeaderTitle');
        const chatWrapper = document.getElementById('chatWrapper');
        const chatBoxView = document.getElementById('chatBoxView');
        const backToListBtn = document.getElementById('backToList');
        const messageInput = document.getElementById('messageInput');
        const chatList = document.getElementById('chatList');
        const fileInput = document.getElementById('fileInput');

        // ===============================
        // Emoji Picker
        // ===============================
        const emojiBtn = document.getElementById('emojiBtn');
        const emojiPicker = document.getElementById('emojiPicker');

        const picker = new EmojiMart.Picker({
            theme: "dark",
            onEmojiSelect: (emoji) => {
                messageInput.value += emoji.native;
                messageInput.focus();
            }
        });
        emojiPicker.appendChild(picker);

        emojiBtn.addEventListener('click', () => {
            emojiPicker.classList.toggle('hidden');
            stickerPanel.classList.add('hidden');
        });

        // ===============================
        // Sticker Panel
        // ===============================
        const stickerBtn = document.getElementById('stickerBtn');
        const stickerPanel = document.getElementById('stickerPanel');
        const stickerSearch = document.getElementById('stickerSearch');
        const stickerResults = document.getElementById('stickerResults');

        // Load trending GIFs
        stickerBtn.addEventListener('click', async () => {
            stickerPanel.classList.toggle('hidden');
            emojiPicker.classList.add('hidden');

            if (stickerResults.innerHTML === '') {
                try {
                    const res = await fetch(`https://tenor.googleapis.com/v2/featured?key=YOUR_TENOR_KEY&limit=12`);
                    const data = await res.json();
                    stickerResults.innerHTML = '';

                    data.results.forEach(item => {
                        const gifUrl = item.media_formats?.gif?.url;
                        if (!gifUrl) return;

                        const img = document.createElement('img');
                        img.src = gifUrl;
                        img.className = "cursor-pointer rounded";
                        img.addEventListener('click', sendSticker);
                        stickerResults.appendChild(img);
                    });
                } catch (err) {
                    console.error('Failed to load trending GIFs:', err);
                }
            }
        });

        // Search GIFs
        stickerSearch.addEventListener('input', async function() {
            const q = this.value.trim();
            if (!q) return;

            try {
                const res = await fetch(`https://tenor.googleapis.com/v2/search?q=${encodeURIComponent(q)}&key=YOUR_TENOR_KEY&limit=12`);
                const data = await res.json();
                stickerResults.innerHTML = '';

                data.results.forEach(item => {
                    const gifUrl = item.media_formats?.gif?.url;
                    if (!gifUrl) return;

                    const img = document.createElement('img');
                    img.src = gifUrl;
                    img.className = "cursor-pointer rounded";
                    img.addEventListener('click', sendSticker);
                    stickerResults.appendChild(img);
                });
            } catch (err) {
                console.error('Failed to search GIFs:', err);
            }
        });

        // Send sticker
        function sendSticker() {
            if (!receiverId) return;

            const formData = new FormData();
            formData.append('receiver_id', receiverId);
            formData.append('type', 'sticker');
            formData.append('message', this.src);

            axios.post('/new-send-message', formData)
                .then(res => {
                    displayMessage(res.data);
                    lastMessageId = res.data.id;
                    updateChatPreview(res.data);
                })
                .catch(err => console.error(err.response?.data));

            stickerPanel.classList.add('hidden');
        }

        // ===============================
        // File Upload
        // ===============================
        fileInput.addEventListener('change', function(e) {
            if (!receiverId) return;
            const file = e.target.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('receiver_id', receiverId);
            formData.append('type', 'file');
            formData.append('file', file);
            formData.append('message', ''); // message required by backend

            axios.post('/new-send-message', formData, {
                headers: { 'Content-Type': 'multipart/form-data' } // important
            })
            .then(res => {
                displayMessage(res.data);
                lastMessageId = res.data.id;
                updateChatPreview(res.data);
            })
            .catch(err => console.error(err.response?.data));

            e.target.value = '';
        });

        let chats = [];
        let groups = @json($groups ?? []);

        document.querySelectorAll('#chatList > div').forEach(div => {
            const id = div.id;

            if (!id.startsWith('chatItem-') || id.startsWith('chatItem-group-')) return;

            const userId = id.replace('chatItem-', '');
            const name = div.querySelector('.font-semibold')?.textContent || 'Unknown';
            const img = div.querySelector('img')?.src || '/default-avatar.png';
            const lastMessage = div.querySelector('p')?.textContent || '';
            const time = div.querySelector('span.text-xs')?.textContent || '';

            chats.push({ id: userId, name, img, lastMessage, time });
        });

        function renderChatList() {
            chatList.innerHTML = '';

            chats.forEach(c => {
                const div = document.createElement('div');
                div.id = `chatItem-${c.id}`;
                div.className = 'flex items-center gap-3 px-4 py-3 cursor-pointer hover:bg-zinc-300 border-b border-zinc-300';
                div.onclick = () => selectUser(c.id, c.name, c.img);

                div.innerHTML = `
                    <div class="relative">
                        <img src="${c.img}" class="w-12 h-12 rounded-full object-cover">
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold">${c.name}</span>
                            <span class="text-xs text-gray-400">${c.time}</span>
                        </div>
                        <p class="text-sm text-gray-400 truncate">${c.lastMessage}</p>
                    </div>
                `;
                chatList.appendChild(div);
            });

            if (groups.length > 0) {
                const header = document.createElement('div');
                header.className = 'px-4 py-2 font-semibold text-gray-500';
                header.textContent = 'Groups';
                chatList.appendChild(header);

                groups.forEach(g => {
                    const div = document.createElement('div');
                    div.id = `chatItem-group-${g.id}`;
                    div.className = 'flex items-center gap-3 px-4 py-3 cursor-pointer hover:bg-zinc-300 border-b border-zinc-300';
                    div.onclick = () => selectGroup(g.id, g.name);

                    const initials = g.name.slice(0,2).toUpperCase();

                    div.innerHTML = `
                        <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
                            ${initials}
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold">${g.name}</span>
                                <span class="text-xs text-gray-400">${g.last_message_time ?? ''}</span>
                            </div>
                            <p class="text-sm text-gray-400 truncate">${g.last_message_preview ?? ''}</p>
                        </div>
                    `;
                    chatList.appendChild(div);
                });
            }
        }

        window.selectUser = async function(id, name, img = '/default-avatar.png') {

            receiverId = id;
            lastMessageId = null;
            chatBox.innerHTML = '';
            chatHeaderTitle.textContent = name;

            chatBoxView.classList.remove('hidden');
            chatWrapper.classList.add('hidden');

            const currentChatId = id;

            try {
                const res = await axios.get('/chat-messages', {
                    params: { receiver_id: currentChatId, last_id: null }
                });

                if (receiverId != currentChatId) return;

                if (res.data.length > 0) {

                    res.data.forEach(msg => displayMessage(msg));
                    lastMessageId = res.data[res.data.length - 1].id;

                    requestAnimationFrame(() => {
                        chatBox.lastElementChild?.scrollIntoView();
                    });

                    if (!chats.find(c => c.id == id)) {
                        chats.unshift({
                            id,
                            name,
                            img,
                            lastMessage: res.data[res.data.length - 1].message 
                                || res.data[res.data.length - 1].type,
                            time: 'Now'
                        });
                    }

                    renderChatList();

                } else {
                    console.log('No messages for this user yet.');
                }

            } catch (err) {
                console.error(err);
            }
        };

        backToListBtn.addEventListener('click', () => {
            chatBoxView.classList.add('hidden');
            chatWrapper.classList.remove('hidden');
            renderChatList();
        });

        async function loadMessages() {
            if (!receiverId && !currentGroupId) return;

            const currentId = receiverId || currentGroupId;
            const params = receiverId ? { receiver_id: currentId, last_id: lastMessageId } : { group_id: currentId, last_id: lastMessageId };

            try {
                const res = await axios.get('/chat-messages', { params });
                if (!res.data.length) return;

                res.data.forEach(msg => {
                    if (document.getElementById('msg-' + msg.id)) return;
                    displayMessage(msg);
                    lastMessageId = msg.id;
                });
            } catch(err) {
                console.error(err);
            }
        }

        // ===============================
        // Send Text Message
        // ===============================
        // window.sendMessage = function() {
        //     if (!receiverId || !messageInput.value.trim()) return;

        //     const text = messageInput.value.trim();
        //     const formData = new FormData();
        //     formData.append('receiver_id', receiverId);
        //     formData.append('type', 'text');
        //     formData.append('message', text);

        //     // ✅ LOG REQUEST DATA
        //     for (let pair of formData.entries()) {
        //         console.log(pair[0] + ':', pair[1]);
        //     }

        //     axios.post('/new-send-message', formData)
        //         .then(res => {
        //             console.log('Response:', res.data); // also log response
        //             displayMessage(res.data);
        //             lastMessageId = res.data.id;
        //             messageInput.value = '';
        //             updateChatPreview(res.data);
        //         })
        //         .catch(err => {
        //             console.log('Error:', err.response?.data);
        //         });
        // };

        window.sendMessage = function() {
            if (!receiverId && !currentGroupId) return; // no recipient

            const text = messageInput.value.trim();
            if (!text) return;

            const formData = new FormData();
            formData.append('type', 'text');
            formData.append('message', text);

            if (receiverId) formData.append('receiver_id', receiverId);
            if (currentGroupId) formData.append('group_id', currentGroupId);

            axios.post('/new-send-message', formData)
                .then(res => {
                    displayMessage(res.data);
                    lastMessageId = res.data.id;
                    messageInput.value = '';

                    if (receiverId) updateChatPreview(res.data);
                    else if (currentGroupId) updateGroupPreview(res.data); // similar to chat preview
                })
                .catch(err => console.error(err));
        };

        function displayMessage(msg) {
            if (document.getElementById('msg-' + msg.id)) return;

            const wrapper = document.createElement('div');
            wrapper.id = 'msg-' + msg.id;
            wrapper.className = 'flex ' + (msg.sender_id == AUTH_ID ? 'justify-end' : 'justify-start');

            const bubble = document.createElement('div');
            bubble.className = 'max-w-[75%] px-4 py-3 rounded-2xl text-sm break-words ' +
                (msg.sender_id == AUTH_ID 
                    ? 'bg-gradient-to-r from-primary to-[#b80a0a] text-white rounded-br-sm shadow-md' 
                    : 'bg-gray-100 dark:bg-zinc-800 text-gray-900 dark:text-zinc-200 rounded-bl-sm shadow-sm');

            // Render based on type
            if (msg.type === 'text' || msg.type === 'emoji') {
                bubble.innerHTML = msg.message;
            } else if (msg.type === 'sticker') {
                bubble.innerHTML = `<img src="${msg.message}" class="rounded-xl max-w-[200px]">`;
            } else if (msg.type === 'image') {
                // Use storage asset path
                bubble.innerHTML = `<img src="${msg.file_path ? '/' + msg.file_path : ''}" class="rounded-xl max-w-full">`;
            } else if (msg.type === 'file') {
                const fileName = msg.original_name || msg.file_path.split('/').pop();
                const ext = fileName.split('.').pop().toLowerCase();

                let icon = 'insert_drive_file'; 
                if (ext === 'pdf') icon = 'picture_as_pdf';
                else if (['doc','docx'].includes(ext)) icon = 'description';
                else if (['xls','xlsx'].includes(ext)) icon = 'grid_view';
                else if (['ppt','pptx'].includes(ext)) icon = 'slideshow';
                else if (['zip','rar','7z'].includes(ext)) icon = 'folder_zip';

                bubble.innerHTML = `
                    <a href="/${msg.file_path}" target="_blank" class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-2xl">${icon}</span>
                        <span class="truncate max-w-[200px]">${fileName}</span>
                    </a>
                `;
            } else if (msg.type === 'voice') {
                        bubble.innerHTML = `<audio controls class="w-full"><source src="${msg.file_path ? '/' + msg.file_path : ''}"></audio>`;
                    }

            wrapper.appendChild(bubble);
            chatBox.appendChild(wrapper);
            // chatBox.scrollTop = chatBox.scrollHeight;
        }

        function updateChatPreview(msg) {
            const chatIndex = chats.findIndex(c => c.id == receiverId);
            const lastMsg = msg.message || msg.type;

            if (chatIndex > -1) {
                chats[chatIndex].lastMessage = lastMsg;
                chats[chatIndex].time = 'Now';
                const chat = chats.splice(chatIndex, 1)[0];
                chats.unshift(chat);
            } else {
                chats.unshift({ id: receiverId, name: chatHeaderTitle.textContent, img: '/default-avatar.png', lastMessage: lastMsg, time: 'Now' });
            }
            renderChatList();
        }

        function updateGroupPreview(msg) {
            const groupIndex = groups.findIndex(g => g.id == msg.group_id);
            const lastMsg = msg.message || msg.type;

            if (groupIndex > -1) {
                groups[groupIndex].last_message_preview = lastMsg;
                groups[groupIndex].last_message_time = 'Now';
                const grp = groups.splice(groupIndex,1)[0];
                groups.unshift(grp);
            } else {
                groups.unshift({ 
                    id: msg.group_id, 
                    name: chatHeaderTitle.textContent, 
                    last_message_preview: lastMsg, 
                    last_message_time: 'Now'
                });
            }
            renderChatList();
        }

        // ===============================
        // Auto Polling
        // ===============================
        setInterval(() => {
            if (receiverId) loadMessages(false);
        }, 2000);

        window.openGroupModal = function(){
            document.getElementById('groupModal').classList.remove('hidden');
        }

        window.closeGroupModal = function(){
            document.getElementById('groupModal').classList.add('hidden');
        }

        window.createGroup = async function(){

            const name = document.getElementById('groupName').value;

            const users = [];

            document.querySelectorAll('.groupUser:checked').forEach(el=>{
                users.push(el.value);
            });

            if(!name){
                alert('Group name required');
                return;
            }

            if(users.length === 0){
                alert('Select at least one user');
                return;
            }

            try{

                const res = await axios.post('/create-group',{
                    name:name,
                    users:users
                });

                alert('Group Created');

                closeGroupModal();

                location.reload();

            }catch(err){
                console.log(err.response?.data);
            }

        }

        window.selectGroup = async function(id, name) {
            receiverId = null; // clear private chat
            lastMessageId = null;
            chatBox.innerHTML = '';
            chatHeaderTitle.textContent = name;

            chatBoxView.classList.remove('hidden');
            chatWrapper.classList.add('hidden');

            currentGroupId = id;

            try {
                const res = await axios.get('/chat-messages', {
                    params: { group_id: currentGroupId, last_id: null }
                });

                if (receiverId || lastMessageId) { // check if switched
                    // ignore
                }

                if (res.data.length > 0) {
                    res.data.forEach(msg => displayMessage(msg));
                    lastMessageId = res.data[res.data.length - 1].id;

                    requestAnimationFrame(() => {
                        chatBox.lastElementChild?.scrollIntoView();
                    });
                }
            } catch (err) {
                console.error(err);
            }
        };

    });
    
</script>
@endsection