@extends('admin.layouts.app')

<style>
    @media (max-width: 480px) {
        .nav-item .nav-link {
            padding: 0.4rem 0.35rem;
        }

        .nav-item a {
            font-size: 12px;
        }

        .action-btns .btn {
            padding: 0.25rem 0.5rem;
            font-size: 11px;
        }
    }
</style>

@section('panel')
    <div class="card layout-top-spacing">
        <div class="card-body">
            <div class="d-flex align-items-center mb-4">
                @php
                    if (preg_match('/^data:image\/(\w+);base64,/', $user->image ?? '')) {
                        $user_image = $user->image;
                    } else {
                        $user_image = $user->image ? asset($user->image) : asset('images/avatar.png');
                    }
                @endphp
                <img src="{{ $user_image }}" class="rounded me-3" style="width:80px;height:80px;object-fit:cover;">
                <div>
                    <h4 class="mb-1">{{ $user->name }}</h4>
                    <div class="text-muted small">
                        <span class="me-3">Phone: {{ $user->phone ?? '—' }}</span>
                        <span class="me-3">Email: {{ $user->email ?? '—' }}</span>
                        <span class="me-3">Username: {{ $user->username ?? '—' }}</span>
                        <span class="me-3">Country: {{ optional($user->country)->name ?? '—' }}</span>
                        <span class="me-3">Balance: {{ currency($user->balance ?? 0) }}</span>
                        <span class="me-3">
                            Password:
                            @php
                                try {
                                    echo isset($user->hp)
                                        ? \Illuminate\Support\Facades\Crypt::decryptString($user->hp)
                                        : '—';
                                } catch (\Exception $e) {
                                    echo '—';
                                }
                            @endphp
                        </span>
                        <span class="me-3">Pin: {{ $user->pin ?? '—' }}</span>
                    </div>
                </div>
                <div class="ms-auto">
                    {!! $user->status() !!}
                </div>
            </div>


            <div class="card mb-3 border-0">
                <div class="card-body py-2">
                    <div class="d-flex flex-wrap align-items-center gap-2 action-btns">
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addBalanceModal">
                            <i class="fa fa-dollar me-1"></i> Add Balance
                        </button>

                        @if ($user->status == 0)
                            <a href="#" class="btn btn-success confirm-btn" data-title="Activate User"
                                data-text="Are you sure you want to activate <strong>{{ $user->name }}</strong>?"
                                data-url="{{ route('user.status', $user->id) }}" data-btn="btn-success"
                                data-label="Activate">
                                <i class="fa fa-check me-1"></i> Activate
                            </a>
                        @else
                            <a href="#" class="btn btn-danger confirm-btn" data-title="Deactivate User"
                                data-text="Are you sure you want to deactivate <strong>{{ $user->name }}</strong>?"
                                data-url="{{ route('user.status', $user->id) }}" data-btn="btn-danger"
                                data-label="Deactivate">
                                <i class="fa fa-times me-1"></i> Deactivate
                            </a>
                        @endif


                        @if ($user->is_blocked == 0)
                            <a href="#" class="btn btn-warning confirm-btn" data-title="Block User"
                                data-text="Are you sure you want to block <strong>{{ $user->name }}</strong>?"
                                data-url="{{ route('user.block', $user->id) }}" data-btn="btn-warning" data-label="Block">
                                <i class="fa fa-ban me-1"></i> Block
                            </a>
                        @else
                            <a href="#" class="btn btn-secondary confirm-btn" data-title="Unblock User"
                                data-text="Are you sure you want to unblock <strong>{{ $user->name }}</strong>?"
                                data-url="{{ route('user.block', $user->id) }}" data-btn="btn-secondary"
                                data-label="Unblock">
                                <i class="fa fa-unlock me-1"></i> Unblock
                            </a>
                        @endif


                        <a href="#" class="btn btn-outline-danger confirm-btn" data-title="Delete User"
                            data-text="This action cannot be undone. Are you sure you want to delete <strong>{{ $user->name }}</strong>?"
                            data-url="{{ route('user.delete', $user->id) }}" data-btn="btn-danger" data-label="Delete">
                            <i class="fa fa-trash me-1"></i> Delete
                        </a>

                        @if ($hasPushSubscription)
                            <button type="button" class="btn btn-outline-primary" id="togglePushFormBtn">
                                <i class="fa fa-bell me-1"></i>
                                Send Notification
                            </button>
                        @else
                            <span class="text-muted small">
                                <i class="fa fa-bell-slash me-1"></i>
                                Notifications not enabled
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="modal fade" id="confirmActionModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmActionTitle">Confirm Action</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body" id="confirmActionText">
                            Are you sure?
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <a href="#" id="confirmActionBtn" class="btn btn-danger">
                                Confirm
                            </a>
                        </div>

                    </div>
                </div>
            </div>

            <div class="modal fade" id="addBalanceModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fa fa-dollar me-1"></i> Add Balance
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <form action="{{ route('user.addbalance',$user->id) }}" method="POST">
                            @csrf

                            <div class="modal-body">

                                <div class="text-center mb-3">
                                    <h6>Name: {{ $user->name }}</h6>
                                    <small class="text-muted">Mobile: {{ $user->phone }}</small>
                                    <br>
                                    <strong>Current Balance: {{ currency($user->balance) }}</strong>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Amount</label>
                                    <input type="number"
                                        name="amount"
                                        class="form-control"
                                        placeholder="Enter amount"
                                        required>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-success">
                                    <i class="fa fa-plus me-1"></i> Add Balance
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <div id="pushFormWrapper" class="d-none">
                        <form method="POST" action="{{ route('admin.user.push.send', $user->id) }}">
                            @csrf

                            <div class="mb-2">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Message</label>
                                <textarea name="body" class="form-control" rows="3" required></textarea>
                            </div>

                            <div class="d-flex gap-2 mt-2">
                                <button class="btn btn-primary">
                                    <i class="fa fa-paper-plane me-1"></i>
                                    Send
                                </button>

                                <button type="button" class="btn btn-light" id="cancelPushFormBtn">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>


            {{-- Tabs --}}
            @php
                $tab = $activeTab ?? 'deposits';
            @endphp
            <ul class="nav nav-tabs" id="userTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ $tab === 'deposits' ? 'active' : '' }}"
                        href="{{ route('admin.users.show', ['user' => $user->id, 'tab' => 'deposits']) }}">Deposits</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ $tab === 'mobile_withdraw' ? 'active' : '' }}"
                        href="{{ route('admin.users.show', ['user' => $user->id, 'tab' => 'mobile_withdraw']) }}">
                        Mobile Transfer</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ $tab === 'bank_withdraw' ? 'active' : '' }}"
                        href="{{ route('admin.users.show', ['user' => $user->id, 'tab' => 'bank_withdraw']) }}">
                        Bank Transfer</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ $tab === 'remittance' ? 'active' : '' }}"
                        href="{{ route('admin.users.show', ['user' => $user->id, 'tab' => 'remittance']) }}">
                        Remittance
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ $tab === 'recharge' ? 'active' : '' }}"
                        href="{{ route('admin.users.show', ['user' => $user->id, 'tab' => 'recharge']) }}">
                        Recharges</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ $tab === 'visits' ? 'active' : '' }}"
                        href="{{ route('admin.users.show', ['user' => $user->id, 'tab' => 'visits']) }}">
                        Visits
                    </a>
                </li>
            </ul>

            <div class="tab-content pt-3">

                @if ($tab === 'deposits')
                    <div class="list-cards">
                        @forelse($topups as $t)
                            <div class="topup-card" data-status="{{ $t->status }}">

                                <div class="topup-slot">
                                    <div>Gateway: {{ optional($t->gateway)->name ?? 'N/A' }}</div>
                                    <div>Transaction: {{ $t->transaction_id ?? '—' }}</div>
                                    <div>Date: {{ $t->created_at?->format('d M Y H:i') }}</div>

                                </div>

                                <div class="topup-slot">

                                    <div>Mobile/Account: {{ $t->mobile ?: $t->account ?: 'N/A' }}</div>
                                    @if ($t->status == 0)
                                        <span class="badge-status status-pending">Pending</span>
                                    @elseif($t->status == 1)
                                        <span class="badge-status status-approved">Approved</span>
                                    @elseif($t->status == 2)
                                        <span class="badge-status status-rejected">Rejected</span>
                                    @endif
                                </div>

                                <div class="topup-slot">
                                    <div class="topup-amount">Amount: ৳ {{ number_format($t->amount ?? 0, 2) }}</div>
                                    <div class="text-muted">Commission: ৳ {{ number_format($t->commision ?? 0, 2) }}</div>
                                    <div class="mt-2 topup-actions">
                                        @if ($t->status == 0)
                                            <a class="btn btn-success btn-circle"
                                                href="{{ route('topup.approve', $t->id) }}"
                                                onclick="return confirm('Approve?')"><i class="fa fa-check"></i></a>
                                            <a class="btn btn-danger btn-circle"
                                                href="{{ route('topup.reject', $t->id) }}"
                                                onclick="return confirm('Reject?')"><i class="fa fa-times"></i></a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted">
                                <img src="{{ asset('assets/images/empty_box.png') }}" width="120" alt="No deposits">
                                <p class="mt-3">No deposits found</p>
                            </div>
                        @endforelse
                    </div>
                @endif

                {{-- Mobile Banking Withdrawals --}}
                @if ($tab === 'mobile_withdraw')
                    <div class="list-cards">
                        @forelse($mobileWithdraws as $mw)
                            <div class="topup-card" data-status="{{ $mw->status }}">

                                <div class="topup-slot">
                                    <div>Operator: {{ $mw->operator ?? 'N/A' }}</div>

                                    <div>Transaction: {{ $mw->transaction_id ?? '—' }}</div>
                                    <div>Date: {{ $mw->created_at?->format('d M Y H:i') }}</div>

                                </div>

                                <div class="topup-slot">
                                    <div>Recepient : {{ $mw->mobile ?? 'N/A' }}</div>
                                    <div>Type: {{ $mw->type ?? 'N/A' }}</div>

                                    @if ($mw->status == 0)
                                        <span class="badge-status status-pending">Pending</span>
                                    @elseif($mw->status == 1)
                                        <span class="badge-status status-approved">Approved</span>
                                    @elseif($mw->status == 2)
                                        <span class="badge-status status-rejected">Rejected</span>
                                    @endif
                                </div>

                                <div class="topup-slot">
                                    <div class="topup-amount">Amount: ৳ {{ number_format($mw->amount ?? 0, 2) }}</div>
                                    <div class="mt-2 topup-actions">
                                        @if ($mw->status == 0)
                                            <a class="btn btn-success btn-circle"
                                                href="{{ route('mobilebankinglist.approve', $mw->id) }}"
                                                onclick="return confirm('Approve?')"><i class="fa fa-check"></i></a>
                                            <a class="btn btn-danger btn-circle"
                                                href="{{ route('mobilebankinglist.reject', $mw->id) }}"
                                                onclick="return confirm('Reject?')"><i class="fa fa-times"></i></a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted">
                                <img src="{{ asset('assets/images/empty_box.png') }}" width="120"
                                    alt="No withdrawals">
                                <p class="mt-3">No mobile banking records found</p>
                            </div>
                        @endforelse
                    </div>
                @endif

                @if (($tab === 'deposits' && $topups->hasPages()) || ($tab === 'mobile_withdraw' && $mobileWithdraws->hasPages()))
                    <div class="mt-4">
                        @if ($tab === 'deposits')
                            {{ $topups->onEachSide(1)->links('pagination::bootstrap-5') }}
                        @elseif($tab === 'mobile_withdraw')
                            {{ $mobileWithdraws->onEachSide(1)->links('pagination::bootstrap-5') }}
                        @endif
                    </div>
                @endif


                {{-- Visits Tab --}}
                @if ($tab === 'visits')
                    <div>

                        {{-- Summary cards --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <h6>Total Visits</h6>
                                        <h4>{{ $totalVisits }}</h4>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <h6>Last Visit</h6>
                                        <h6 class="text-muted">
                                            {{ $lastVisit?->created_at?->subHours(6)?->diffForHumans() ?? 'Never' }}
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="list-cards">
                            @forelse($visits as $v)
                                <div class="topup-card" data-status="">

                                    <div class="topup-slot">
                                        <div class="topup-user">{{ $v->user?->name ?? 'Guest' }}</div>
                                        <div class="topup-phone">{{ $v->user?->phone ?? '—' }}</div>
                                    </div>

                                    <div class="topup-slot">
                                        <div>Date: {{ $v->created_at->format('d M Y, H:i') }}</div>
                                    </div>

                                </div>
                            @empty
                                <div class="text-center py-5 text-muted">
                                    <img src="{{ asset('assets/images/empty_box.png') }}" width="120"
                                        alt="No visits">
                                    <p class="mt-3">No visit records found.</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="mt-3 d-flex justify-content-end">
                            {{ $visits->onEachSide(1)->appends(['tab' => 'visits'])->links('pagination::bootstrap-5') }}
                        </div>

                    </div>
                @endif

                {{-- Bank Transfers Tab --}}
                @if ($tab === 'bank_withdraw')
                    <input type="text" id="searchBank" class="search-box mb-3"
                        placeholder="Search bank transfers...">

                    <div class="list-cards">
                        @forelse($bankPays as $bp)
                            <div class="topup-card" data-status="{{ $bp->status }}">

                                <div class="topup-slot">
                                    <div>Bank/Operator: {{ $bp->operator ?? 'N/A' }}</div>

                                    <div>Transaction: {{ $bp->transaction_id ?? '—' }}</div>
                                    <div>Date: {{ $bp->created_at?->format('d M Y H:i') }}</div>

                                </div>

                                <div class="topup-slot">
                                    <div>Account/Number: {{ $bp->number ?? ($bp->mobile ?? 'N/A') }}</div>
                                    <div>Branch: {{ $bp->branch ?? 'N/A' }}</div>
                                    <div>Account Holder: {{ $bp->achold ?? 'N/A' }}</div>

                                    @if ($bp->status == 0)
                                        <span class="badge-status status-pending">Pending</span>
                                    @elseif($bp->status == 1)
                                        <span class="badge-status status-approved">Approved</span>
                                    @elseif($bp->status == 2)
                                        <span class="badge-status status-rejected">Rejected</span>
                                    @endif
                                </div>

                                <div class="topup-slot">
                                    <div class="topup-amount">Amount: ৳ {{ number_format($bp->amount ?? 0, 2) }}</div>
                                    <div class="mt-2 topup-actions">
                                        @if ($bp->status == 0)
                                            <a class="btn btn-success btn-circle"
                                                href="{{ route('bankpay.approve', $bp->id) }}"
                                                onclick="return confirm('Approve?')">
                                                <i class="fa fa-check"></i>
                                            </a>
                                            <a class="btn btn-danger btn-circle"
                                                href="{{ route('bankpay.reject', $bp->id) }}"
                                                onclick="return confirm('Reject?')">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        @empty
                            <div class="text-center py-5 text-muted">
                                <img src="{{ asset('assets/images/empty_box.png') }}" width="120"
                                    alt="No bank transfers">
                                <p class="mt-3">No bank transfers found.</p>
                            </div>
                        @endforelse
                    </div>

                    @if ($bankPays->hasPages())
                        <div class="mt-4">
                            {{ $bankPays->onEachSide(1)->appends(['tab' => 'bank_withdraw', 'bank_q' => $qBank])->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                @endif

                {{-- Remittance Tab --}}
                @if ($tab === 'remittance')
                    <input type="text" id="searchRemit" class="search-box mb-3" placeholder="Search remittance...">

                    <div class="list-cards">
                        @forelse($remittances as $r)
                            <div class="topup-card" data-status="{{ $r->status }}">

                                <div class="topup-slot">
                                    <div>Operator: {{ $r->operator ?? 'N/A' }}</div>
                                    <div>Transaction: {{ $r->transaction_id ?? '—' }}</div>
                                    <div>Date: {{ $r->created_at?->format('d M Y H:i') }}</div>

                                </div>

                                <div class="topup-slot">

                                    <div>Account: {{ $r->account ?? 'N/A' }}</div>
                                    <div>Branch: {{ $r->branch ?? 'N/A' }}</div>
                                    <div>Account Holder: {{ $r->achold ?? 'N/A' }}</div>

                                    @if ($r->status == 0)
                                        <span class="badge-status status-pending">Pending</span>
                                    @elseif($r->status == 1)
                                        <span class="badge-status status-approved">Approved</span>
                                    @elseif($r->status == 2)
                                        <span class="badge-status status-rejected">Rejected</span>
                                    @endif
                                </div>

                                <div class="topup-slot">
                                    <div class="topup-amount">Amount: ৳ {{ number_format($r->amount ?? 0, 2) }}</div>
                                    <div class="mt-2 topup-actions">
                                        @if ((int) $r->status === 0)
                                            <a class="btn btn-success btn-circle"
                                                href="{{ route('remittance.approve', $r->id) }}"
                                                onclick="return confirm('Approve this remittance?')">
                                                <i class="fa fa-check"></i>
                                            </a>
                                            <a class="btn btn-danger btn-circle"
                                                href="{{ route('remittance.reject', $r->id) }}"
                                                onclick="return confirm('Reject this remittance?')">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        @empty
                            <div class="text-center py-5 text-muted">
                                <img src="{{ asset('assets/images/empty_box.png') }}" width="120"
                                    alt="No remittances">
                                <p class="mt-3">No remittance records found.</p>
                            </div>
                        @endforelse
                    </div>

                    @if ($remittances->hasPages())
                        <div class="mt-4">
                            {{ $remittances->onEachSide(1)->appends(['tab' => 'remittance', 'remit_q' => $qRemit])->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                @endif

                {{-- Mobile Recharges Tab --}}
                @if ($tab === 'recharge')
                    <input type="text" id="searchRecharge" class="search-box mb-3"
                        placeholder="Search mobile recharges...">

                    <div class="list-cards">
                        @forelse($mobileRecharges as $mr)
                            <div class="topup-card" data-status="{{ $mr->status }}">

                                <div class="topup-slot">
                                    <div>Operator: {{ $mr->operator ?? 'N/A' }}</div>
                                    <div>Type: {{ $mr->type ?? 'N/A' }}</div>
                                    <div>Date: {{ $mr->created_at?->format('d M Y H:i') }}</div>
                                </div>

                                <div class="topup-slot">

                                    <div>Recepient: {{ $mr->mobile ?? 'N/A' }}</div>
                                    @if ($mr->status == 0)
                                        <span class="badge-status status-pending">Pending</span>
                                    @elseif($mr->status == 1)
                                        <span class="badge-status status-approved">Approved</span>
                                    @elseif($mr->status == 2)
                                        <span class="badge-status status-rejected">Rejected</span>
                                    @endif
                                </div>

                                <div class="topup-slot">
                                    <div class="topup-amount">Amount: ৳ {{ number_format($mr->amount ?? 0, 2) }}</div>
                                    <div class="mt-2 topup-actions">
                                        @if ($mr->status == 0)
                                            <a class="btn btn-success btn-circle"
                                                href="{{ route('recharge.approve', $mr->id) }}"><i
                                                    class="fa fa-check"></i></a>
                                            <a class="btn btn-danger btn-circle"
                                                href="{{ route('recharge.reject', $mr->id) }}"><i
                                                    class="fa fa-times"></i></a>
                                        @endif
                                        <a class="btn btn-danger btn-circle"
                                            href="{{ route('recharge.delete', $mr->id) }}"><i
                                                class="bx bx-trash"></i></a>
                                    </div>
                                </div>

                            </div>
                        @empty
                            <div class="text-center py-5 text-muted">
                                <img src="{{ asset('assets/images/empty_box.png') }}" width="120" alt="No recharges">
                                <p class="mt-3">No mobile recharges found.</p>
                            </div>
                        @endforelse
                    </div>

                    @if ($mobileRecharges->hasPages())
                        <div class="mt-4">
                            {{ $mobileRecharges->onEachSide(1)->appends(['tab' => 'recharge', 'rc_q' => $qRc])->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                @endif

            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        const toggleBtn = document.getElementById('togglePushFormBtn');
        const cancelBtn = document.getElementById('cancelPushFormBtn');
        const formWrap = document.getElementById('pushFormWrapper');

        toggleBtn?.addEventListener('click', () => {
            formWrap.classList.toggle('d-none');
        });

        cancelBtn?.addEventListener('click', () => {
            formWrap.classList.add('d-none');
        });
    </script>
    <script>
        document.addEventListener("click", function(e) {

            const btn = e.target.closest(".confirm-btn");
            if (!btn) return;

            e.preventDefault();

            const title = btn.dataset.title;
            const text = btn.dataset.text;
            const url = btn.dataset.url;
            const btnClass = btn.dataset.btn;
            const label = btn.dataset.label;

            document.getElementById("confirmActionTitle").innerHTML = title;
            document.getElementById("confirmActionText").innerHTML = text;

            const confirmBtn = document.getElementById("confirmActionBtn");
            confirmBtn.href = url;
            confirmBtn.className = "btn " + btnClass;
            confirmBtn.innerHTML = label;

            const modal = new bootstrap.Modal(document.getElementById("confirmActionModal"));
            modal.show();

        });
    </script>
@endpush
