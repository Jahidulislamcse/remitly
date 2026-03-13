@extends('admin.layouts.app')

<style>
    @media (max-width: 480px) {
        .nav-item .nav-link {
            padding: 0.4rem 0.35rem;
        }
        .nav-item a {
            font-size: 12px;
        }
    }
</style>

@php
    $pageTitle = isset($title) ? $title : 'Users';
    $tab = request('tab', 'with_balance');
    $search = request('search', '');
@endphp

@section('panel')
    <div class="mb-3">
        <input type="text" id="searchInput" class="search-box" placeholder="Search users...">
    </div>

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a class="nav-link {{ $tab === 'with_balance' ? 'active' : '' }}"
                href="{{ url()->current() }}?tab=with_balance&search={{ $search }}">
                Users With Balance
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $tab === 'no_balance' ? 'active' : '' }}"
                href="{{ url()->current() }}?tab=no_balance&search={{ $search }}">
                Users Without Balance
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $tab === 'visitors' ? 'active' : '' }}" href="{{ url()->current() }}?tab=visitors">
                Recent Visitors
            </a>
        </li>
    </ul>

    <div class="list-cards" style="max-height: 600px; overflow-y: auto;">
        @forelse($lists as $list)
            <div class="topup-card">
                <div class="topup-slot">
                    @if ($tab === 'visitors')
                        <div class="topup-user">{{ optional($list->user)->name ?? 'Guest' }}</div>
                        <div class="topup-phone">{{ optional($list->user)->phone ?? '-' }}</div>
                        <div class="topup-country">{{ optional(optional($list->user)->country)->name }}</div>
                        <div class="topup-status">
                            <span class="badge bg-info">
                                {{ $list->created_at->diffForHumans() }}
                            </span>
                        </div>
                    @else
                        <div class="topup-user">{{ $list->name }}</div>
                        <div class="topup-phone">{{ $list->phone }}</div>
                        <div class="topup-country">{{ optional($list->country)->name }}</div>
                        <div class="topup-balance">Balance: {{ currency($list->balance) }}</div>
                    @endif
                </div>

                <div class="topup-slot">
                    <div>
                        @php
                            $img = $tab === 'visitors' ? optional($list->user)->image : $list->image;
                        @endphp
                        <img src="{{ $img ? (preg_match('/^data:image/', $img) ? $img : asset($img)) : asset('assets/images/default_user.png') }}"
                            width="60" style="border-radius:12%; height:60px;">
                    </div>

                    @if ($tab !== 'visitors' && isset($list->status))
                        <div class="topup-status mt-1">{!! $list->status() !!}</div>
                    @endif
                </div>

                <div class="topup-slot topup-actions mt-2">
                    @if ($tab === 'visitors' && $list->user)
                        <a href="{{ route('admin.users.show', $list->user->id) }}" class="btn btn-primary btn-sm">View</a>
                    @elseif($tab !== 'visitors')
                        <a href="{{ route('admin.users.show', $list->id) }}" class="btn btn-primary btn-sm">View</a>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <img src="{{ asset('assets/images/empty_box.png') }}" width="120">
                <p class="mt-3 text-muted">No records found</p>
            </div>
        @endforelse
    </div>

    @if ($lists->hasPages())
        <div class="mt-4">
            {{ $lists->links('pagination::bootstrap-5') }}
        </div>
    @endif
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const cards = document.querySelectorAll('.list-cards .topup-card');

            searchInput.addEventListener('input', function() {
                const searchTerm = searchInput.value.toLowerCase();
                cards.forEach(card => {
                    const matches = card.textContent.toLowerCase().includes(searchTerm);
                    card.style.display = matches ? '' : 'none';
                });
            });
        });
    </script>
@endpush
