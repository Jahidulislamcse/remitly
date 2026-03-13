@extends('admin.layouts.app')

@php
    $pageTitle = isset($title) ? $title : 'Identity Builder';
@endphp

@section('panel')
    <div class="row">

        {{-- Form Card --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.chat.links.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" placeholder="Profile Name" required class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Customer Handler</label>
                            <input type="text" name="subtitle" placeholder="Ex: Agent / Support" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Country</label>
                            <input type="text" name="country" placeholder="e.g. Bangladesh" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Profile Picture</label>
                            <input type="file" name="image" class="form-control" accept="image/*" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-bolt me-2"></i> Generate Link
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Filter + List --}}
        <div class="col-md-8">
            <input type="text" id="subtitleSearch" class="form-control mb-3" placeholder="Search Handler..."
                onkeyup="filterSubtitle()">

            <div class="mb-3 d-flex gap-2 flex-wrap" id="filterButtons">
                <button class="btn btn-outline-secondary active" onclick="filterItems('all', event)">All Region</button>
                @php $uniqueCountries = $links->pluck('country')->unique()->filter(); @endphp
                @foreach ($uniqueCountries as $country)
                    <button class="btn btn-outline-secondary"
                        onclick="filterItems('{{ strtolower($country) }}', event)">{{ strtoupper($country) }}</button>
                @endforeach
            </div>

            <div class="list-cards" style="max-height:500px; overflow-y:auto;">
                @forelse($links as $link)
                    <div class="card mb-2 id-item-obj" data-country="{{ strtolower($link->country) }}"
                        data-subtitle="{{ strtolower($link->subtitle ?? '') }}">
                        <div class="card-body d-flex justify-content-between align-items-center">

                            <div class="d-flex align-items-center">
                                <img src="{{ asset($link->avatar) }}" class="rounded me-3" width="55" height="55">
                                <div>
                                    <h6 class="mb-1">{{ $link->name }}</h6>
                                    @if (!empty($link->subtitle))
                                        <span class="badge bg-success me-1">{{ $link->subtitle }}</span>
                                    @endif
                                    <span class="badge bg-secondary">{{ $link->country ?? 'Global' }}</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-2">
                                <label class="form-check form-switch m-0">
                                    <input class="form-check-input" type="checkbox"
                                        onchange="toggleStatus({{ $link->id }})"
                                        {{ $link->is_online ? 'checked' : '' }}>
                                </label>
                                <a href="{{ route('guest.chat.join', $link->token) }}" target="_blank"
                                    class="btn btn-sm btn-success">
                                    <i class="fas fa-external-link-alt"></i> JOIN
                                </a>
                                <button class="btn btn-sm btn-outline-success"
                                    onclick="copyToClipboard('{{ route('guest.chat.join', $link->token) }}', this)">
                                    <i class="far fa-copy"></i>
                                </button>
                                <a href="{{ route('admin.chat.links.delete', $link->id) }}"
                                    onclick="return confirm('Delete this profile?')" class="btn btn-sm btn-danger">
                                    <i class="far fa-trash-alt"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted">
                        No Identities Active
                    </div>
                @endforelse
            </div>
        </div>

    </div>
@endsection

@push('script')
    <script>
        function toggleStatus(id) {
            fetch("{{ route('admin.chat.links.toggle') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        id: id
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) location.reload();
                })
                .catch(err => alert('Something went wrong!'));
        }

        function copyToClipboard(text, btn) {
            navigator.clipboard.writeText(text).then(() => {
                const old = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-check"></i>';
                setTimeout(() => btn.innerHTML = old, 1500);
            });
        }

        function filterItems(country, e) {
            document.querySelectorAll('#filterButtons button').forEach(btn => btn.classList.remove('active'));
            e.currentTarget.classList.add('active');

            document.querySelectorAll('.id-item-obj').forEach(item => {
                item.style.display = (country === 'all' || item.dataset.country === country) ? 'flex' : 'none';
            });
        }

        function filterSubtitle() {
            let val = document.getElementById('subtitleSearch').value.toLowerCase();
            document.querySelectorAll('.id-item-obj').forEach(item => {
                item.style.display = item.dataset.subtitle.includes(val) ? 'flex' : 'none';
            });
        }
    </script>
@endpush
