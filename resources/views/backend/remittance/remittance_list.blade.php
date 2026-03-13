@extends('admin.layouts.app')

@php
    $pageTitle = isset($title) ? $title : 'Remittance Requests';
@endphp

@section('panel')
    <div class="mb-3">
        <button class="toggle-btn active" data-status="">All</button>
        <button class="toggle-btn" data-status="0">Pending</button>
        <button class="toggle-btn" data-status="1">Approved</button>
        <button class="toggle-btn" data-status="2">Rejected</button>
    </div>

    <input type="text" id="searchInput" class="search-box" placeholder="Search transactions...">

    <div class="list-cards" style="max-height: 600px; overflow-y: auto;">
        @forelse($lists as $list)
            <div class="topup-card" data-status="{{ $list->status }}">

                <div class="topup-slot">
                    <div class="topup-user">{{ $list->user->name }}</div>
                    <div class="topup-phone">{{ $list->user->phone }}</div>
                    <div class="topup-phone">Date: {{ $list->created_at->format('d M Y') }}</div>
                </div>

                <div class="topup-slot">
                    <div><strong>Transaction:</strong> {{ $list->transaction_id }}</div>
                    <div><strong>Operator:</strong> {{ $list->operator }}</div>
                    <div><strong>Account:</strong> {{ $list->mobile }}</div>
                    <div><strong>Holder:</strong> {{ $list->achold }}</div>
                    <div><strong>Branch:</strong> {{ $list->branch }}</div>

                    @if ($list->status == 0)
                        <span class="badge-status status-pending">Pending</span>
                    @elseif($list->status == 1)
                        <span class="badge-status status-approved">Approved</span>
                    @elseif($list->status == 2)
                        <span class="badge-status status-rejected">Rejected</span>
                    @endif
                </div>

                <div class="topup-slot topup-actions mt-2">
                    @if ($list->amount)
                        <div class="topup-amount">Amount: ৳ {{ number_format($list->amount, 2) }}</div>
                    @endif
                    @if ($list->status == 0)
                        <a class="btn btn-success btn-circle" href="{{ route('remittance.approve', $list->id) }}"
                            onclick="return confirm('Approve?')">
                            <i class="fa fa-check"></i>
                        </a>
                        <a class="btn btn-danger btn-circle" href="{{ route('remittance.reject', $list->id) }}"
                            onclick="return confirm('Reject?')">
                            <i class="fa fa-times"></i>
                        </a>
                    @else
                        <a class="btn btn-danger btn-circle" href="{{ route('remittance.delete', $list->id) }}"
                            onclick="return confirm('Delete?')">
                            <i class="bx bx-trash"></i>
                        </a>
                    @endif
                </div>

            </div>
        @empty
            <div class="col-12 text-center py-5">
                <img src="{{ asset('assets/images/empty_box.png') }}" width="120">
                <p class="mt-3 text-muted">No remittance requests found</p>
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
                    const cardStatus = card.dataset.status;
                    const matchesStatus = !activeStatus || cardStatus === activeStatus;
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

            // initial filter to reflect default active button
            filterCards();
        });
    </script>
@endpush
