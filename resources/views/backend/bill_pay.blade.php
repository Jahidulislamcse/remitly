@extends('backend.layout.master')

@section('meta')
@endsection

@section('style')
<style>
    .image-radio-group {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }
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

    .image-radio {
        display: flex;
        align-items: center;
        margin: 5px;
        cursor: pointer;
    }

    .image-radio input[type="radio"] {
        margin-right: 5px;
        width: 15px;
        height: 15px;
    }

    .radio-btn {
        display: inline-block;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        background-color: #fff;
        border: 2px solid #787878ff;
        margin-right: 5px;
    }

    .image-radio img {
        width: 25px;
        height: 25px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 5px;
    }

    .image-radio p {
        font-size: 14px;
        color: #000;
        margin: 0;
    }

    input[type="radio"]:checked+.radio-btn {
        background-color: #067fab;
        border-color: #6e6e6eff;
    }

    input[type="radio"]:checked+.radio-btn+img+p {
        color: #4CAF50;
    }
</style>
@endsection

@section('main')

<div class="app-header st1">
    <div class="tf-container">
        <div class="tf-topbar d-flex justify-content-center align-items-center">
            <a href="{{ route('user.index') }}" class="back-btn"><i class="icon-left white_color"></i></a>
            <h3 class="white_color">বিল পে</h3>
        </div>
    </div>
</div>

<div class="card-secton topup-content mt-2">
    @php $country = country(); @endphp
    <form class="tf-form" method="post">
        @csrf
        <div class="tf-container">
            <div class="tf-balance-box">
                <div class="d-flex justify-content-between align-items-center"></div>
                <div class="image-radio-group">
                    <!-- Electricity Bill Option -->
                    <label class="image-radio">
                        <input type="radio" name="operator" checked value="বিদ্যুৎ বিল">
                        <span class="radio-btn"></span>
                        <img src="{{ asset('images/electricity.png') }}" alt="Electricity">
                        <p>বিদ্যুৎ</p>
                    </label>

                    <!-- Gas Bill Option -->
                    <label class="image-radio">
                        <input type="radio" name="operator" value="গ্যাস">
                        <span class="radio-btn"></span>
                        <img src="{{ asset('images/gas-bill.png') }}" alt="Gas">
                        <p>গ্যাস</p>
                    </label>

                    <!-- Water Bill Option -->
                    <label class="image-radio">
                        <input type="radio" name="operator" value="পানি">
                        <span class="radio-btn"></span>
                        <img src="{{ asset('images/73-730316_faucetnew11132015-utility-bill-icon-png.png') }}" alt="Water">
                        <p>পানি</p>
                    </label>

                    <!-- TV Bill Option -->
                    <label class="image-radio">
                        <input type="radio" name="operator" value="টিভি">
                        <span class="radio-btn"></span>
                        <img src="{{ asset('images/195149.png') }}" alt="TV">
                        <p>টিভি</p>
                    </label>

                    <!-- Internet Bill Option -->
                    <label class="image-radio">
                        <input type="radio" name="operator" value="ইন্টারনেট">
                        <span class="radio-btn"></span>
                        <img src="{{ asset('images/net-bill.png') }}" alt="Internet">
                        <p>ইন্টারনেট</p>
                    </label>
                </div>

                <div class="wrap-sl-country mt-3">
                     <select name="type" class="box-sl-profile form-select" required>
                         <option value="">বিলের ধরন সিলেক্ট করুন</option>
                         <option value="prepaid">প্রি পেইড</option>
                         <option value="postpaid">পোস্ট পেইড</option>
                     </select>
                 </div>

                <!-- User ID Input -->
                <div class="tf-form">
                    <div class="form-group input-field input-money">
                        <label for="">ইউজার আইডি</label>
                        <input name="mobile" type="number" placeholder="00000000" maxlength="11" required>
                        <span class="icon-clear"></span>
                    </div>
                </div>

                <div class="tf-form">
                    <div class="form-group input-field input-money">
                        <label for="">সেবা দানকারী প্রতিষ্ঠানের নাম লিখুন</label>
                        <input name="company" type="text" placeholder="পল্লী বিদ্যুৎ, তিতাস, ওয়াসা" required>
                        <span class="icon-clear"></span>
                    </div>
                </div>

                <!-- Amount Input -->
                <div class="tf-form">
                    <div class="form-group input-field input-money">
                        <label for="">এমাউন্ট</label>
                        <input name="amount" type="number" max="{{ auth()->user()->balance }}" value="200" required class="search-field value_input st1">
                        <span class="icon-clear"></span>
                    </div>
                </div>

                <!-- Pin Input -->
                <div class="tf-form">
                    <div class="form-group input-field input-money">
                        <label for="">পিন</label>
                        <input name="pin" type="text" placeholder="123456" required>
                        <span class="icon-clear"></span>
                    </div>
                </div>

                <!-- Balance Display -->
                <h3 class="text-center" style="margin-top: 30px;">ব্যবহারযোগ্য ব্যালেন্স: {{ currency(auth()->user()->balance) }} টাকা</h3>
            </div>
        </div>

        <button type="submit" name="submit" class="tf-btn accent small">অ্যাড করুন</button>
    </form>
</div>

<div class="tf-panel up">
    <div class="panel_overlay"></div>
    <div class="panel-box panel-up wrap-content-panel"></div>
</div>

@endsection

@section('script')
@endsection