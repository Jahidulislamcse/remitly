@extends('admin.layouts.app')

@php
    $pageTitle = isset($title) ? $title : 'Deposits';
@endphp

@section('panel')
    <div class="mb-3">
        <button class="toggle-btn active" data-status="">All</button>
        <button class="toggle-btn" data-status="0">Pending</button>
        <button class="toggle-btn" data-status="1">Approved</button>
        <button class="toggle-btn" data-status="2">Rejected</button>
    </div>

    <input type="text" id="searchInput" class="search-box" placeholder="Search topups...">

    <div class="list-cards" style="max-height: 600px; overflow-y: auto;">
        @forelse($lists as $list)
            <div class="topup-card" data-status="{{ $list->status }}">

                <div class="topup-slot">
                    @if ($list->user?->name)
                        <div class="topup-user">{{ $list->user->name }}</div>
                    @endif
                    @if ($list->user?->phone)
                        <div class="topup-phone">{{ $list->user->phone }}</div>
                    @endif
                    @if (isset($list->user->balance))
                        <div class="topup-balance"><strong>Balance:</strong> ৳ {{ number_format($list->user->balance, 2) }}</div>
                    @endif
                </div>

                <div class="topup-slot">
                    @if ($list->transaction_id)
                        <div><strong>Trx:</strong> {{ $list->transaction_id }}</div>
                    @endif
                    @if ($list->mobile)
                        <div><strong>Pin:</strong> {{ $list->mobile }}</div>
                    @endif
                    @if (optional($list->gateway)->name)
                        <div><strong>Account:</strong> {{ optional($list->gateway)->name }}</div>
                    @endif
                    @if ($list->created_at)
                        <div><strong>Date:</strong> {{ $list->created_at->format('d M Y H:i') }}</div>
                    @endif
                    @if ($list->file)
                        <div><strong>Receipt:</strong> <a href="{{ asset($list->file) }}" target="_blank">View</a></div>
                    @endif
                    @if ($list->status == 0)
                        <span class="badge-status status-pending">Pending</span>
                    @elseif($list->status == 1)
                        <span class="badge-status status-approved">Approved</span>
                    @elseif($list->status == 2)
                        <span class="badge-status status-rejected">Rejected</span>
                    @endif
                </div>

                <div class="topup-slot">
                    @if ($list->amount)
                        <div class="topup-amount">Amount: ৳ {{ number_format($list->amount, 2) }}</div>
                    @endif
                    @if ($list->commision)
                        <div class="text-muted"> <strong>Commission:</strong> ৳ {{ number_format($list->commision, 2) }}</div>
                    @endif
                    <div class="mt-2 topup-actions">
                        @if ($list->status == 0)
                            <a class="btn btn-success btn-circle " href="{{ route('topup.approve', $list->id) }}"
                                onclick="return confirm('Approve?')">
                                <i class="fa fa-check"></i>
                            </a>
                            <a class="btn btn-danger btn-circle " href="{{ route('topup.reject', $list->id) }}"
                                onclick="return confirm('Reject?')">
                                <i class="fa fa-times"></i>
                            </a>
                        @endif
                    </div>
                </div>

            </div>
        @empty
            <div class="col-12 text-center py-5">
                <img src="{{ asset('assets/images/empty_box.png') }}" width="120">
                <p class="mt-3 text-muted">No topup requests found</p>
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
            const buttons = document.querySelectorAll('.toggle-btn');
            const cards = document.querySelectorAll('.list-cards .topup-card');
            const searchInput = document.getElementById('searchInput');

            function filterCards() {
                const activeStatus = document.querySelector('.toggle-btn.active').dataset.status;
                const searchTerm = searchInput.value.toLowerCase();

                cards.forEach(card => {
                    const matchesStatus = !activeStatus || card.dataset.status === activeStatus;
                    const matchesSearch = card.textContent.toLowerCase().includes(searchTerm);
                    card.style.display = (matchesStatus && matchesSearch) ? '' : 'none';
                });
            }

            buttons.forEach(btn => {
                btn.addEventListener('click', function() {
                    buttons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    filterCards();
                });
            });

            searchInput.addEventListener('input', filterCards);
        });
    </script>
@endpush
