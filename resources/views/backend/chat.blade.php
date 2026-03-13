@extends('admin.layouts.app')

@php
    $pageTitle = 'Moderation Panel';
@endphp

@section('panel')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                {{-- Toolbar --}}
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <div class="d-flex gap-2">
                        <button id="btn-refresh" class="btn btn-outline-secondary btn-sm">Refresh</button>
                    </div>
                    <div class="d-flex gap-2">
                        <input type="search" id="searchBox" class="form-control form-control-sm" placeholder="Search...">
                        <select id="pageSize" class="form-select form-select-sm">
                            <option value="50">50 Items</option>
                        </select>
                    </div>
                </div>

                {{-- Scrollable List --}}
                <div id="items-list" style="max-height:500px; overflow-y:auto;">
                    <!-- Items rendered by JS -->
                </div>

                {{-- Pagination / Info --}}
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <div id="countInfo" class="small text-muted"></div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-secondary btn-sm" id="prevPage">Prev</button>
                        <button class="btn btn-outline-secondary btn-sm" id="nextPage">Next</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
(function() {
    const state = { page:0, size:50, rows:[] };
    const chatBase = "{{ $chatApiBase }}".replace(/\/$/, "");
    const mainBase = "{{ url('/') }}".replace(/\/$/, "");

    function getSafeAvatar(r){
        const path = r.user_image_path || r.user_image || r.profile_picture || "";
        if(!path || path==="NULL" || path==="") return chatBase+"/assets/files/site_users/profile_pics/default.png";
        if(path.startsWith('http')) return path;
        if(path.includes('assets/')) return chatBase + '/' + path.replace(/^\/+/, '');
        return mainBase + '/' + path.replace(/^\/+/, '');
    }

    async function load(){
        const params = new URLSearchParams({ limit: state.size, offset: state.page*state.size });
        const res = await fetch(`{{ route('admin.chat.pending') }}?${params.toString()}`, { headers:{'X-Requested-With':'XMLHttpRequest'} });
        const json = await res.json();
        state.rows = Array.isArray(json.data) ? json.data : [];
        render();
    }

    function render(){
        const container = document.getElementById('items-list');
        container.innerHTML = '';

        state.rows.forEach(r=>{
            const avatar = getSafeAvatar(r);
            let mediaHtml = '';
            if(r.attachments){
                try{
                    const a = JSON.parse(r.attachments);
                    const data = Array.isArray(a)?a[0]:a;
                    const fileName = data.file||data.image||data.video||data.audio_message;
                    if(fileName){
                        const url = chatBase + '/' + fileName.replace(/^\.?\//,'');
                        if(r.attachment_type==='image_files') mediaHtml=`<img src="${url}" class="img-fluid rounded mt-2" style="max-width:180px;">`;
                        else if(r.attachment_type==='audio_message') mediaHtml=`<audio controls class="mt-2" style="width:220px;"><source src="${url}" type="audio/mpeg"></audio>`;
                        else if(r.attachment_type==='video_files') mediaHtml=`<video controls class="mt-2" style="max-width:220px;"><source src="${url}" type="video/mp4"></video>`;
                    }
                }catch(e){console.warn(e);}
            }

            const card = document.createElement('div');
            card.className = "card mb-2";
            card.innerHTML = `
                <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-3 flex-grow-1">
                        <img src="${avatar}" class="rounded" width="50" height="50">
                        <div>
                            <h6 class="mb-1">${r.display_name||r.username}</h6>
                            <small class="text-muted">${r.group_name||'Public Group'}</small>
                        </div>
                    </div>
                    <div class="flex-grow-2 mx-3">
                        <span class="badge bg-warning text-dark mb-1">Pending Approval</span>
                        <p class="mb-0">${r.filtered_message||r.original_message||'Media Message'}</p>
                        ${mediaHtml}
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-success btn-sm" data-act="approve" data-id="${r.message_id}">Approve</button>
                        <button class="btn btn-danger btn-sm" data-act="reject" data-id="${r.message_id}">Reject</button>
                    </div>
                </div>
            `;
            container.appendChild(card);
        });

        document.getElementById('countInfo').textContent = `Total ${state.rows.length} records`;
    }

    async function callAction(url, ids){
        if(!ids.length) return;
        await fetch(url,{
            method:'POST',
            headers:{ 'Content-Type':'application/json', 'X-CSRF-TOKEN':'{{ csrf_token() }}','X-Requested-With':'XMLHttpRequest' },
            body: JSON.stringify({ message_ids: ids })
        });
        load();
    }

    document.getElementById('btn-refresh').addEventListener('click', load);
    document.getElementById('items-list').addEventListener('click', e=>{
        const b = e.target.closest('button[data-act]');
        if(!b) return;
        const id = Number(b.dataset.id);
        if(b.dataset.act==='approve') callAction(`{{ route('admin.chat.approve') }}`, [id]);
        if(b.dataset.act==='reject')  callAction(`{{ route('admin.chat.reject') }}`,  [id]);
    });

    load();
})();
</script>
@endsection