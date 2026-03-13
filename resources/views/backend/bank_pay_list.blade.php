@extends('admin.layouts.app')

@php
    $pageTitle = 'Bank Withdraw Requests';
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

        @foreach ($lists as $list)
            <div class="topup-card" data-status="{{ $list->status }}">
                <div class="topup-slot">
                    <div class="topup-user">{{ $list->user->name }}</div>
                    <div class="topup-phone">{{ $list->user->phone }}</div>
                    @if (isset($list->user->balance))
                        <div class="topup-balance"><strong>Balance:</strong> ৳ {{ number_format($list->user->balance, 2) }}</div>
                    @endif
                    <div class="topup-phone">
                        <strong>Date:</strong> {{ $list->created_at->format('d M Y') }}
                    </div>
                </div>

                <div class="topup-slot">
                    <div><strong>Transaction:</strong> {{ $list->transaction_id }}</div>
                    <div><strong>Operator:</strong> {{ $list->operator }}</div>
                    <div><strong>Account:</strong> {{ $list->mobile }}</div>
                    <div><strong>Holder:</strong> {{ $list->achold }}</div>
                    <div><strong>Branch:</strong> {{ $list->branch }}</div>

                    {!! $list->status() !!}
                </div>

                <div class="topup-slot">
                    <div class="topup-amount">Amount ৳ {{ number_format($list->amount, 2) }}</div>

                    <div class="topup-actions">
                        @if ($list->status == 0)
                            <a class="btn btn-success btn-circle" href="{{ route('bankpay.approve', $list->id) }}">
                                <i class="fa fa-check"></i>
                            </a>

                            <a class="btn btn-danger btn-circle" href="{{ route('bankpay.reject', $list->id) }}">
                                <i class="fa fa-times"></i>
                            </a>
                        @else
                            <a class="btn btn-danger btn-circle" href="{{ route('bankpay.delete', $list->id) }}">
                                <i class="fa fa-trash"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
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
                    const cardStatus = card.dataset.status; // ensure comparison as string
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

            // Initial filter
            filterCards();
        });
    </script>
@endpush
