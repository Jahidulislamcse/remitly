@extends('admin.layouts.app')

@php
    $pageTitle = isset($title) ? $title : 'Mobile Bank List';
@endphp

@section('panel')
    @php
        $operators = ['bkash' => 'Bkash', 'nagad' => 'Nagad', 'rocket' => 'Rocket', 'upay' => 'Upay'];
    @endphp

    <div class="mb-2 toggle-group operator-toggle">
        <button class="toggle-btn active" data-operator=""
            onclick="window.location='{{ route('mobilebank.list', ['operator' => 'bkash']) }}'">
            All
        </button>
        @foreach ($operators as $key => $name)
            <button class="toggle-btn" data-operator="{{ $key }}"
                onclick="window.location='{{ route('mobilebank.list', ['operator' => $key]) }}'">
                {{ $name }}
            </button>
        @endforeach
    </div>

    <div class="mb-2 toggle-group status-toggle">
        <button class="toggle-btn active" data-status="">All</button>
        <button class="toggle-btn" data-status="0">Pending</button>
        <button class="toggle-btn" data-status="1">Approved</button>
        <button class="toggle-btn" data-status="2">Rejected</button>
    </div>



    <input type="text" id="searchInput" class="search-box" placeholder="Search transactions...">

    <div class="list-cards" style="max-height: 600px; overflow-y: auto;">
        @forelse($lists as $list)
            <div class="topup-card" data-status="{{ $list->status }}" data-operator="{{ strtolower($list->operator) }}">
                <div class="topup-slot">
                    @if ($list->user?->name)
                        <div class="topup-user">{{ $list->user->name }}</div>
                    @endif
                    @if ($list->user?->phone)
                        <div class="topup-phone">{{ $list->user->phone }}</div>
                    @endif
                    <div class="topup-phone"><strong>Date:</strong> {{ $list->created_at->format('d M Y H:i') }}</div>
                </div>

                <div class="topup-slot">
                    @if ($list->transaction_id)
                        <div><strong>Transaction:</strong> {{ $list->transaction_id }}</div>
                    @endif
                    @if ($list->mobile)
                        <div><strong>Phone:</strong> {{ $list->mobile }}</div>
                    @endif
                    @if ($list->operator)
                        <div><strong>Operator:</strong> {{ $list->operator }}</div>
                    @endif
                    @if ($list->type)
                        <div><strong>Type:</strong> {{ $list->type }}</div>
                    @endif
                    @if ($list->pin)
                        <div><strong>Pin:</strong> {{ $list->pin }}</div>
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
                        <div class="text-muted"><strong>Commission:</strong> ৳ {{ number_format($list->commision, 2) }}
                        </div>
                    @endif
                    <div class="topup-actions">
                        @if ($list->status == 0)
                            <button type="button" class="btn btn-success btn-circle"
                                onclick="showPinModal('{{ route('mobilebankinglist.approve', $list->id) }}')">
                                <i class="fa fa-check"></i>
                            </button>
                            <a class="btn btn-danger btn-circle" href="{{ route('mobilebankinglist.reject', $list->id) }}"
                                onclick="return confirmAction('reject')">
                                <i class="fa fa-times"></i>
                            </a>
                        @else
                            <a class="btn btn-danger btn-circle" href="{{ route('mobilebankinglist.delete', $list->id) }}"
                                onclick="return confirmAction('delete')">
                                <i class="bx bx-trash"></i>
                            </a>
                        @endif
                    </div>
                </div>


            </div>
        @empty
            <div class="col-12 text-center py-5">
                <img src="{{ asset('assets/images/empty_box.png') }}" width="120">
                <p class="mt-3 text-muted">No transactions found</p>
            </div>
        @endforelse
    </div>

    @if ($lists->hasPages())
        <div class="mt-4">
            {{ $lists->links('pagination::bootstrap-5') }}
        </div>
    @endif

    <div class="modal fade" id="pinModal" tabindex="-1" aria-labelledby="pinModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" style="margin-top: 130px;">
            <div class="modal-content">
                <form id="pinForm" method="POST" action="">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="pinModalLabel">Enter PIN / Agent Last numbers</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="password" name="pin" class="form-control" placeholder="Enter PIN" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success btn-sm">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const operatorGroup = document.querySelector('.operator-toggle');
            const statusGroup = document.querySelector('.status-toggle');

            const currentOperator = "{{ $operator ?? 'bkash' }}";

            operatorGroup.querySelectorAll('.toggle-btn').forEach(btn => {
                btn.classList.remove('active');
                if (btn.dataset.operator === currentOperator || (btn.dataset.operator === '' &&
                        currentOperator === 'bkash')) {
                    btn.classList.add('active');
                }
            });

            const statusButtons = statusGroup.querySelectorAll('.toggle-btn');
            const operatorButtons = operatorGroup.querySelectorAll('.toggle-btn');
            const cards = document.querySelectorAll('.list-cards .topup-card');
            const searchInput = document.getElementById('searchInput');

            function filterCards() {
                const activeStatus = statusGroup.querySelector('.toggle-btn.active').dataset.status;
                const activeOperator = operatorGroup.querySelector('.toggle-btn.active').dataset.operator
                    .toLowerCase();
                const searchTerm = searchInput.value.toLowerCase();

                cards.forEach(card => {
                    const cardOperator = card.dataset.operator.toLowerCase();
                    const matchesStatus = !activeStatus || card.dataset.status === activeStatus;
                    const matchesOperator = !activeOperator || cardOperator === activeOperator;
                    const matchesSearch = card.textContent.toLowerCase().includes(searchTerm);
                    card.style.display = (matchesStatus && matchesOperator && matchesSearch) ? '' : 'none';
                });
            }

            statusButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    statusButtons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    filterCards();
                });
            });

            operatorButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    operatorButtons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    filterCards();
                });
            });

            searchInput.addEventListener('input', filterCards);
        });

        function confirmAction(action) {
            let message = '';
            switch (action) {
                case 'approve':
                    message = 'Are you sure you want to approve this?';
                    break;
                case 'reject':
                    message = 'Are you sure you want to reject this?';
                    break;
                case 'delete':
                    message = 'Are you sure you want to delete this?';
                    break;
            }
            return confirm(message);
        }

        function showPinModal(url) {
            document.getElementById('pinForm').action = url;
            var pinModal = new bootstrap.Modal(document.getElementById('pinModal'));
            pinModal.show();
        }
    </script>
@endpush
