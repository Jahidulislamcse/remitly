<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

@extends('backend.layout.master')
@section('meta')



@endsection
@section('style')

<style>
     @php
        $colors = \App\Models\ColorSetting::first();
    @endphp
    .app-header {
        background-color: {{ $colors->header_color ?? '#067fab' }};
    }
    body {
        background-color: {{ $colors->body_color ?? '#067fab' }};
    }
            h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: 'SolaimanLipi', 'Noto Sans Bengali', sans-serif !important;
        font-weight: 400;
        color: {{ $colors->headings_color ?? '#ffffff' }};
    }
    label {
      color: {{ $colors->label_color ?? '#ffffff' }};   
    }
    p {
      color: {{ $colors->paragraph_color ?? '#ffffff' }};   
    }
    
    .avatar-upload {
        position: relative;
        max-width: 205px;


        .avatar-edit {
            position: absolute;

            z-index: 1;
            top: 10px;

            input {
                display: none;

                +label {
                    display: inline-block;
                    width: 34px;
                    height: 34px;
                    margin-bottom: 0;
                    border-radius: 100%;
                    background: #FFFFFF;
                    border: 1px solid transparent;
                    box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
                    cursor: pointer;
                    font-weight: normal;
                    transition: all .2s ease-in-out;

                    &:hover {
                        background: #f1f1f1;
                        border-color: #d6d6d6;
                    }

                    &:after {
                        content: "\f040";
                        font-family: 'FontAwesome';
                        color: #757575;
                        position: absolute;
                        top: 10px;
                        left: 0;
                        right: 0;
                        text-align: center;
                        margin: auto;
                    }
                }
            }
        }

        .avatar-preview {
            width: 100px;
            height: 100px;
            position: relative;
            border-radius: 100%;
            border: 6px solid #F8F8F8;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);

            >div {
                width: 100%;
                height: 100%;
                border-radius: 100%;
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
            }
        }
    }

    .custom-btn {
        background: transparent !important;
        border: 1px solid #067fab;
        border-radius: 50px;
        color: #000000ff;
        padding: 8px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .info-card-sm {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
        width: 100%;
        height: 150px;
        border-radius: 15px;
        border: 1px solid #067fab;
        color: white;
        cursor: pointer;
        margin: 0 5px;
    }

    .info-card-sm:hover {
        background-color: #067fab;
    }

    .info-card-sm i {
        font-size: 2.8rem;
        margin-bottom: 15px;
        transition: all 0.3s ease-in-out;
    }

    .info-card-sm h2 {
        margin: 10px 10px;
        font-size: 1rem;
        text-align: center;
        font-weight: normal;
        text-transform: uppercase;
    }

    .info-card-sm h2:hover {
        color: white;
    }

    .info-card-sm p {
        font-size: 1rem;
        color: #d1d1d1;
    }

    /* Flex Layout for the cards */
    .row {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    .row .col-md-3 {
        display: flex;
        justify-content: center;
        margin-bottom: 5px;
        flex: 1 0 23%;
        padding: 5px;
    }


    @media (max-width: 767px) {
        .row .col-md-3 {
            flex: 1 0 45%;
        }
    }

    .modal-header {
        background-color: #f8f8f8;
    }

    .modal-body {
        padding: 20px;
    }
</style>


@endsection
@section('main')
 <div class="app-header st1">
     <div class="tf-container">
         <div class="tf-topbar d-flex justify-content-center align-items-center">
             <a href="{{  route('user.index')  }}" class="back-btn"><i class="icon-left white_color"></i></a>
             <h3 class="white_color">প্রোফাইল</h3>
         </div>
     </div>
 </div>
<div class="row layout-top-spacing">
    <div class="row ">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="header">
            <div class="tf-container">
                <div class="tf-statusbar br-none d-flex justify-content-center align-items-center">
                    <a href="{{ back() }}" class="back-btn"> <i class="icon-left"></i> </a>
                </div>
            </div>
        </div>

        <div class="col-xl-12  m-2 col-lg-12 col-md-12 layout-spacing">
            <form action=" {{ route('profile') }}" method="post" class="section general-info"
                enctype="multipart/form-data">
                @csrf
                <div class="info">
                    <h6 class="text-center">আপনার তথ্য সমূহ</h6>
                    <div class="row">
                        <div class="col-lg-11 mx-auto">
                            <div class="row">
                                <div class="col-xl-2 col-lg-12 col-md-4" style="display: flex; justify-content: center;">
                                    <div class="profile-image  mt-4 pe-md-4">
                                        <div class="avatar-upload">
                                            <div class="avatar-edit">
                                                <input type='file' id="image" name="image" accept=".png, .jpg, .jpeg" />
                                                <label for="image"></label>
                                            </div>
                                            <div class="avatar-preview">
                                                <div id="imagePreview"
                                                    style="background-image: url(@if(@$data->image) {{ asset(@$data->image) }} @else  https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/330px-No-Image-Placeholder.svg.png?20200912122019 @endif);">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                    <div class="form">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="fullName">আপনার নাম</label>
                                                    <input type="text" class="form-control mb-3" id="fullName"
                                                        placeholder="Full Name" name="name" value="{{ @$data->name }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="profession">ইউজার নাম</label>
                                                    <input type="text" class="form-control mb-3" id="profession"
                                                        placeholder="username" name="username"
                                                        value="{{ @$data->username }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="address">ঠিকানা</label>
                                                    <input type="text" class="form-control mb-3" id="address"
                                                        placeholder="Address" name="address"
                                                        value="{{ @$data->address }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="phone">নাম্বার</label>
                                                    <input type="text" class="form-control mb-3" id="phone"
                                                        placeholder="Write your phone number here" name="phone"
                                                        value="{{ @$data->phone }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">ই-মেইল</label>
                                                    <input type="email" class="form-control mb-3" id="email"
                                                        placeholder="Write your email here" name="email"
                                                        value="{{ @$data->email }}">
                                                </div>
                                            </div>

                                            <div class="col-md-12 mt-1">
                                                <div class="form-group text-end">
                                                    <button
                                                        class="btn btn-secondary _effect--ripple waves-effect waves-light">Save</button>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-1">
                                                <div class="form-group text-end">
                                                    <button type="button"
                                                        class="btn custom-btn _effect--ripple waves-effect waves-light"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#changePasswordModal">
                                                        Change Password
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row mt-6">
                                                <div class="col-md-3">
                                                    <div class="info-card-sm" data-bs-toggle="modal" data-bs-target="#depositModal" onclick="history.replaceState({}, '', '?show=deposit')">
                                                        <i class="fa fa-key"></i>
                                                        <h2>ডিপোজিট সমূহ</h2>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="info-card-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#mobileWithdrawModal"
                                                        onclick="history.replaceState({}, '', '?show=mobile_withdraw')">
                                                        <i class="fa fa-phone"></i>
                                                        <h2>মোবাইল ব্যাংকিং উত্তোলন সমূহ</h2>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="info-card-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#bankWithdrawModal"
                                                        onclick="history.replaceState({}, '', '?show=bank_withdraw')">
                                                        <i class="fa fa-map-marker"></i>
                                                        <h2>ব্যাংক ট্রান্সফার সমূহ</h2>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="info-card-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#rechargeModal"
                                                        onclick="history.replaceState({}, '', '?show=recharge')">
                                                        <i class="fa fa-map-marker"></i>
                                                        <h2>মোবাইল রিচার্জ সমূহ</h2>
                                                    </div>
                                                </div>
                                            </div>
                                             <h2 class="mt-6 text-center">মোট অর্জিত কমিশন : {{ @$data->commision }} টাকা </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="text-black modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('change.password') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="text-black" for="currentPassword">Current Password</label>
                        <input type="password" class="form-control" id="currentPassword" name="current_password" placeholder="Enter current password" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="text-black" for="newPassword">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="new_password" placeholder="Enter new password" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="text-black" for="confirmPassword">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="new_password_confirmation" placeholder="Confirm new password" required>
                    </div>
                    <button type="submit" class="btn btn-secondary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="depositModal" tabindex="-1" aria-labelledby="depositModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="text-black modal-title" id="depositModalLabel">ডিপোজিট সমূহ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                @if($topups->count())
                <form method="GET" action="{{ route('profile') }}" class="row g-2 align-items-center mb-3">
                    <div class="col">
                        <input type="search"
                            class="form-control"
                            id="depositSearch"
                            name="q"
                            placeholder="সার্চ করুন (তারিখ/গেটওয়ে/ট্রান্স্যাকশন/পরিমাণ)..."
                            value="{{ request('q') }}">
                        <input type="hidden" name="show" value="deposit"> {{-- keep modal open after submit --}}
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>তারিখ</th>
                                <th>মাধ্যম</th>
                                <th>#ট্রান্স্যাকশন </th>
                                <th class="text-end">পরিমাণ</th>
                                <th class="text-end">কমিশন</th>
                                <th>স্ট্যাটাস</th>
                                <th>ফাইল</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topups as $t)
                            <tr>
                                <td>{{ $topups->firstItem() + $loop->index }}</td>
                                <td>{{ $t->created_at?->format('d M Y, h:i A') }}</td>
                                <td>{{ optional($t->gateway)->name ?? 'N/A' }}</td>
                                <td>{{ $t->transaction_id ?? '—' }}</td>
                                <td class="text-end">{{ number_format((float)($t->amount ?? 0), 2) }}</td>
                                <td class="text-end">{{ number_format((float)($t->commision ?? 0), 2) }}</td>
                                <td>{!! $t->status() !!}</td>
                                <td>
                                    @if($t->file)
                                    <a href="{{ asset($t->file) }}" target="_blank" class="btn btn-sm btn-outline-primary">দেখুন</a>
                                    @else
                                    —
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    {{ $topups->onEachSide(1)->appends(['show' => 'deposit', 'q' => request('q')])->links('pagination::bootstrap-5') }}
                </div>
                @else
                <div class="text-center py-4 text-muted">কোনো তথ্য পাওয়া যায়নি।</div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mobileWithdrawModal" tabindex="-1" aria-labelledby="mobileWithdrawLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="text-black modal-title" id="mobileWithdrawLabel">মোবাইল ব্যাংকিং উত্তোলন ইতিহাস</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                @if($mobileWithdraws->count())
                <form method="GET" action="{{ route('profile') }}" class="row g-2 align-items-center mb-3">
                    <div class="col">
                        <input type="search"
                            class="form-control"
                            id="mobileWithdrawSearch"
                            name="q_mb"
                            placeholder="সার্চ করুন (অপারেটর/মোবাইল/টাইপ/ট্রান্স্যাকশন/পরিমাণ)..."
                            value="{{ request('q_mb') }}">
                        <input type="hidden" name="show" value="mobile_withdraw">
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>তারিখ</th>
                                <th>অপারেটর</th>
                                <th>টাইপ</th>
                                <th>#ট্রান্স্যাকশন</th>
                                <th>মোবাইল</th>
                                <th class="text-end">পরিমাণ</th>
                                <th>স্ট্যাটাস</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mobileWithdraws as $mw)
                            <tr>
                                <td>{{ $mobileWithdraws->firstItem() + $loop->index }}</td>
                                <td>{{ $mw->created_at?->format('d M Y, h:i A') }}</td>
                                <td>{{ $mw->operator ?? 'N/A' }}</td>
                                <td>{{ $mw->type ?? 'N/A' }}</td>
                                <td>{{ $mw->transaction_id ?? '—' }}</td>
                                <td>{{ $mw->mobile ?? 'N/A' }}</td>
                                <td class="text-end">{{ number_format((float)($mw->amount ?? 0), 2) }}</td>
                                <td>{!! $mw->status() !!}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination (Bootstrap 5) --}}
                <div class="d-flex justify-content-end mt-3">
                    {{ $mobileWithdraws->onEachSide(1)->appends([
                'show'  => 'mobile_withdraw',
                'q_mb'  => request('q_mb'),
                'q'     => request('q') // keep other modal's q if present
            ])->links('pagination::bootstrap-5') }}
                </div>
                @else
                <div class="text-center py-4 text-muted">কোনো মোবাইল ব্যাংকিং উত্তোলন পাওয়া যায়নি।</div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="bankWithdrawModal" tabindex="-1" aria-labelledby="bankWithdrawLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="text-black modal-title" id="bankWithdrawLabel">ব্যাংক ট্রান্সফার ইতিহাস</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                @if($bankPays->count())
                <form method="GET" action="{{ route('profile') }}" class="row g-2 align-items-center mb-3">
                    <div class="col">
                        <input type="search"
                            class="form-control"
                            id="bankWithdrawSearch"
                            name="q_bank"
                            placeholder="সার্চ করুন (ব্যাংক/টাইপ/ট্রান্স্যাকশন/নম্বর/ব্রাঞ্চ/হোল্ডার/মোবাইল/পরিমাণ)..."
                            value="{{ request('q_bank') }}">
                        <input type="hidden" name="show" value="bank_withdraw">
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>তারিখ</th>
                                <th>ব্যাংক/অপারেটর</th>
                                <th>#ট্রান্স্যাকশন</th>
                                <th>অ্যাকাউন্ট/নম্বর</th>
                                <th>ব্রাঞ্চ</th>
                                <th>অ্যাকাউন্ট হোল্ডার</th>
                                <th class="text-end">পরিমাণ</th>
                                <th>স্ট্যাটাস</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bankPays as $bp)
                            <tr>
                                <td>{{ $bankPays->firstItem() + $loop->index }}</td>
                                <td>{{ $bp->created_at?->format('d M Y, h:i A') }}</td>
                                <td>{{ $bp->operator ?? 'N/A' }}</td>
                                <td>{{ $bp->transaction_id ?? '—' }}</td>
                                <td>{{ $bp->number ?? $bp->mobile ?? 'N/A' }}</td>
                                <td>{{ $bp->branch ?? 'N/A' }}</td>
                                <td>{{ $bp->achold ?? 'N/A' }}</td>
                                <td class="text-end">{{ number_format((float)($bp->amount ?? 0), 2) }}</td>
                                <td>{!! $bp->status() !!}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination (Bootstrap 5) --}}
                <div class="d-flex justify-content-end mt-3">
                    {{ $bankPays->onEachSide(1)->appends([
                'show'   => 'bank_withdraw',
                'q_bank' => request('q_bank'),
                // keep other modal queries if present, purely optional:
                'q'      => request('q'),
                'q_mb'   => request('q_mb'),
            ])->links('pagination::bootstrap-5') }}
                </div>
                @else
                <div class="text-center py-4 text-muted">কোনো ব্যাংক ট্রান্সফার পাওয়া যায়নি।</div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="rechargeModal" tabindex="-1" aria-labelledby="rechargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="text-black modal-title" id="rechargeModalLabel">মোবাইল রিচার্জ ইতিহাস</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                @if($mobileRecharges->count())

                {{-- Server-side search (keeps modal open) --}}
                <form method="GET" action="{{ route('profile') }}" class="row g-2 align-items-center mb-3">
                    <div class="col">
                        <input type="search"
                            class="form-control"
                            id="rechargeSearch"
                            name="q_rc"
                            placeholder="সার্চ করুন (অপারেটর/টাইপ/মোবাইল/পরিমাণ)..."
                            value="{{ request('q_rc') }}">
                        <input type="hidden" name="show" value="recharge">
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>তারিখ</th>
                                <th>অপারেটর</th>
                                <th>টাইপ</th>
                                <th>মোবাইল</th>
                                <th class="text-end">পরিমাণ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mobileRecharges as $mr)
                            <tr>
                                <td>{{ $mobileRecharges->firstItem() + $loop->index }}</td>
                                <td>{{ $mr->created_at?->format('d M Y, h:i A') }}</td>
                                <td>{{ $mr->operator ?? 'N/A' }}</td>
                                <td>{{ $mr->type ?? 'N/A' }}</td>
                                <td>{{ $mr->mobile ?? 'N/A' }}</td>
                                <td class="text-end">{{ number_format((float)($mr->amount ?? 0), 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-end mt-3">
                    {{ $mobileRecharges->onEachSide(1)->appends([
                'show'  => 'recharge',
                'q_rc'  => request('q_rc'),
                // keep other modal queries if you want:
                'q'     => request('q'),
                'q_mb'  => request('q_mb'),
                'q_bank'=> request('q_bank'),
            ])->links('pagination::bootstrap-5') }}
                </div>

                @else
                <div class="text-center py-4 text-muted">কোনো মোবাইল রিচার্জ পাওয়া যায়নি।</div>
                @endif
            </div>
        </div>
    </div>
</div>


@if(!empty($showDeposit) && $showDeposit)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const el = document.getElementById('depositModal');
        if (el) new bootstrap.Modal(el).show();
    });
</script>
@endif

@if(!empty($showMobileWithdraw) && $showMobileWithdraw)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const el = document.getElementById('mobileWithdrawModal');
        if (el) new bootstrap.Modal(el).show();
    });
</script>
@endif

@if(!empty($showBankWithdraw) && $showBankWithdraw)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const el = document.getElementById('bankWithdrawModal');
        if (el) new bootstrap.Modal(el).show();
    });
</script>
@endif

@if(!empty($showRecharge) && $showRecharge)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const el = document.getElementById('rechargeModal');
        if (el) new bootstrap.Modal(el).show();
    });
</script>
@endif


@endsection
@section('script')
<script>
    document.addEventListener('input', function(e) {
        if (e.target && e.target.id === 'depositSearch') {
            const q = e.target.value.toLowerCase();
            document.querySelectorAll('#depositModal tbody tr').forEach(function(row) {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        }
    });
</script>

<script>
    document.addEventListener('input', function(e) {
        if (e.target && e.target.id === 'mobileWithdrawSearch') {
            const q = e.target.value.toLowerCase();
            document.querySelectorAll('#mobileWithdrawModal tbody tr').forEach(function(row) {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        }
    });
</script>

<script>
    document.addEventListener('input', function(e) {
        if (e.target && e.target.id === 'bankWithdrawSearch') {
            const q = e.target.value.toLowerCase();
            document.querySelectorAll('#bankWithdrawModal tbody tr').forEach(function(row) {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        }
    });
</script>

<script>
    document.addEventListener('input', function(e) {
        if (e.target && e.target.id === 'rechargeSearch') {
            const q = e.target.value.toLowerCase();
            document.querySelectorAll('#rechargeModal tbody tr').forEach(function(row) {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        }
    });
</script>

<script>
    function openModalRoute(showKey) {
        const url = new URL(location.href);
        ['show', 'q', 'q_mb', 'q_bank', 'q_rc',
            'page', 'deposit_page', 'mobile_withdraw_page', 'bank_withdraw_page', 'recharge_page'
        ].forEach(k => url.searchParams.delete(k));
        url.searchParams.set('show', showKey);
        history.replaceState({}, '', url.pathname + '?' + url.searchParams.toString());
    }

    document.addEventListener('DOMContentLoaded', function() {
        const allModalIds = ['depositModal', 'mobileWithdrawModal', 'bankWithdrawModal', 'rechargeModal'];
        const allKeys = ['show', 'q', 'q_mb', 'q_bank', 'q_rc',
            'page', 'deposit_page', 'mobile_withdraw_page', 'bank_withdraw_page', 'recharge_page'
        ];

        allModalIds.forEach(id => {
            const el = document.getElementById(id);
            if (!el) return;
            el.addEventListener('hidden.bs.modal', function() {
                const url = new URL(location.href);
                allKeys.forEach(k => url.searchParams.delete(k));
                const qs = url.searchParams.toString();
                history.replaceState({}, '', url.pathname + (qs ? '?' + qs : '') + url.hash);
            });
        });
    });
</script>

<script>
    $("#image").change(function() {
        readlogoURL(this);
    });

    function readlogoURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<script src="{{ asset('admin/js/apexcharts.min.js') }} "></script>
<script src="{{ asset('admin/js/dashboard-custom.js') }} "></script>


@endsection