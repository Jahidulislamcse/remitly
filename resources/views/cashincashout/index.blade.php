@extends('backend.layout.master')
@section('meta')
@endsection

@section('style')

@endsection

@section('main')
    <style>
        .cic-container-custom {
            padding-left: 10px;
            padding-right: 10px;
        }

        .modal-content {
            padding: 20px;
        }

        .cic-records-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .cic-records-table th, .cic-records-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            font-size: 16px;
            vertical-align: middle;
        }

        .cic-records-table th {
            background-color: #ff1100ff;
            color: #fff;
            font-weight: bold;
        }

        .cic-records-table td {
            font-size: 14px;
        }

        .cic-records-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .cic-records-table tr:hover {
            background-color: #f1f1f1;
        }

        .cic-records-table .badge {
            font-size: 14px;
            padding: 5px 10px;
            border-radius: 20px;
            color: white;
        }

        .btn-info {
            background-color: #17a2b8;
            color: white;
            font-weight: bold;
        }

        .btn-info:hover {
            background-color: #138496;
        }

        .text-primary {
            color: #007bff;
            font-size: 16px;
            font-weight: bold;
        }




        .cic-toggle-buttons {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 20px;
        }

        .cic-toggle-buttons button {
            margin-right: 10px;
            border-radius: 5px;
        }

        .cic-active {
            background-color: #007bff;
            color: white;
        }

        .cic-toggle-section {
            display: none;
        }

        .cic-form-group {
        }

        .cic-container {
            max-width: 1000px;
            margin: 0 auto;
            padding-left: 15px;
            padding-right: 15px;
        }

        .cic-mobile-banking, .cic-bank-accounts {
            margin-bottom: 20px;
        }

        .cic-mobile-banking .cic-payment-item, .cic-bank-accounts .cic-payment-item {
            margin: 5px 0;
        }

        .btn-toggle {
            margin-top: 10px;
        }

        .cic-btn-inline-container {
            display: flex;
            gap: 10px;
        }

        .gateway-data{
            color: black;
            padding-left: 20px;
        }

        .cic-btn-inline-container .btn {
            margin: 0;
            width: 150px;
            height: 30px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            font-size: 0.85rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .cic-btn-cic-mobile-banking {
            background-color: #28a745;
        }

        .cic-btn-cic-bank-accounts {
            background-color: #ffc107;
        }

        .cic-btn-cic-mobile-banking:hover {
            background-color: #218838;
        }

        .cic-btn-cic-bank-accounts:hover {
            background-color: #e0a800;
        }

        .cic-payment-details {
            display: none;
            margin-top: 5px;
        }

        .cic-payment-name {
            cursor: pointer;
            color: #007bff;
        }
    </style>
    <div class="cic-container-custom ">
        <h3 class="mb-4">Cash In / Withdraw Requests</h3>

        <div class="cic-toggle-buttons">
            <button class="btn btn-primary" id="cicDepositBtn" onclick="toggleSection('cicDeposit')">Deposit</button>
            <button class="btn btn-secondary" id="cicWithdrawBtn" onclick="toggleSection('cicWithdraw')">Withdraw</button>
        </div>

        <div id="cicDepositSection" class="cic-toggle-section">
            <form action="{{ route('cashincashout.store') }}" method="POST">
                @csrf

                <div class="cic-mobile-banking">
                    <div class="cic-btn-inline-container">
                        <button type="button" class="btn cic-btn-cic-mobile-banking" onclick="toggleInnerSection('mobileBanking')">Mobile Banking</button>
                        <button type="button" class="btn cic-btn-cic-bank-accounts" onclick="toggleInnerSection('bankAccounts')">Bank Accounts</button>
                    </div>
                    <div id="mobileBanking" class="scrollable-section cic-toggle-section">
                        @foreach($paymentMethods as $payment)
                            @if($payment->number)
                                <div class="cic-payment-item">
                                    <div class="cic-payment-name" onclick="togglePaymentDetails('mobileBanking-{{ $payment->id }}')">
                                        <input type="radio" name="payment_method" value="{{ $payment->id }}" class="form-check-input" required>
                                        {{ ucfirst($payment->gateway) }}
                                    </div>
                                    <div id="mobileBanking-{{ $payment->id }}" class="cic-payment-details">
                                        <p class="gateway-data">Phone Number: {{ $payment->number }}</p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div id="bankAccounts" class="scrollable-section cic-toggle-section">
                    @foreach($paymentMethods as $payment)
                        @if($payment->routing_number && $payment->account_number)
                            <div class="cic-payment-item">
                                <div class="cic-payment-name" onclick="togglePaymentDetails('bankAccounts-{{ $payment->id }}')">
                                    <input type="radio" name="payment_method" value="{{ $payment->id }}" class="form-check-input" required>
                                    {{ ucfirst($payment->gateway) }}
                                </div>
                                <div id="bankAccounts-{{ $payment->id }}" class="cic-payment-details">
                                    <p class="gateway-data">Routing Number: {{ $payment->routing_number }}</p>
                                    <p class="gateway-data">Account Number: {{ $payment->account_number }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="cic-form-group">
                    <label for="amount">Amount</label>
                    <input type="number" name="amount" id="amount" class="form-control" required min="1">
                </div>

                <input type="hidden" name="type" value="cash_in">
                <div class="cic-form-group">
                    <label for="transaction_number">Transaction Number</label>
                    <input type="text" name="transaction_number" id="transaction_number" class="form-control" required>
                </div>

                <input type="hidden" name="type" value="cash_in">
                <div id="sendingPhoneNumberField" class="cic-form-group" style="display:none;">
                    <label for="sending_phone_number">Sender Number</label>
                    <input type="text" name="sending_phone_number" id="sending_phone_number" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success mt-3">Submit Deposit Request</button>
            </form>
        </div>

        <div id="cicWithdrawSection" class="cic-toggle-section">
        </div>

       <div class="cic-container mt-5">
        <h4 class="text-primary mb-3">Deposit Requests</h4>
        <table class="cic-records-table">
            <thead>
                <tr>
                    <th>Transaction Number</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($depositRequests as $request)
                    <tr>
                        <td class="text-black">{{ $request->transaction_number }}</td>
                        <td class="text-black">${{ number_format($request->amount, 2) }}</td>
                        <td><span class="badge {{ $request->status == 'pending' ? 'bg-warning' : ($request->status == 'approved' ? 'bg-success' : 'bg-danger') }}">{{ ucfirst($request->status) }}</span></td>
                       <td>
                            <a href="#" class="btn btn-info btn-sm" onclick="openModal({{ $request->id }})">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="cic-container mt-5">
        <h4 class="text-primary mb-3">Withdraw Requests</h4>
        <table class="cic-records-table">
            <thead>
                <tr>
                    <th>Transaction Number</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($withdrawRequests as $request)
                    <tr>
                        <td class="text-black">{{ $request->transaction_number }}</td>
                        <td class="text-black">${{ number_format($request->amount, 2) }}</td>
                        <td><span class="badge {{ $request->status == 'pending' ? 'bg-warning' : ($request->status == 'approved' ? 'bg-success' : 'bg-danger') }}">{{ ucfirst($request->status) }}</span></td>
                        <td>
                            <a href="#" class="btn btn-info btn-sm" onclick="openModal({{ $request->id }})">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal for Viewing Request Details -->
    <div id="statusModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Transaction Details</h5>
                </div>
                <div class="modal-body">
                    <p><strong>Transaction Number: </strong><span id="transaction_number"></span></p>
                    <p><strong>Amount: </strong><span id="amount"></span></p>
                    <p><strong>Status: </strong><span id="status"></span></p>
                    <p><strong>Payment Method: </strong><span id="payment_method"></span></p>
                    <p><strong>Sender Phone: </strong><span id="sender_phone"></span></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.cic-toggle-section').hide();
            $('#cicDepositBtn').removeClass('cic-active');
            $('#cicWithdrawBtn').removeClass('cic-active');

            window.toggleSection = function (section) {
                if ($('#' + section + 'Section').is(':visible')) {
                    $('#' + section + 'Section').hide();
                    $('#' + section + 'Btn').removeClass('cic-active');
                } else {
                    $('.cic-toggle-section').hide();
                    $('#cicDepositBtn').removeClass('cic-active');
                    $('#cicWithdrawBtn').removeClass('cic-active');

                    $('#' + section + 'Section').show();
                    if (section === 'cicDeposit') {
                        $('#cicDepositBtn').addClass('cic-active');
                    } else {
                        $('#cicWithdrawBtn').addClass('cic-active');
                    }
                }
            };

             window.toggleInnerSection = function (section) {
                if ($('#' + section).is(':visible')) {
                    $('#' + section).hide();
                } else {
                    if (section === 'mobileBanking') {
                        $('#mobileBanking').show();
                        $('#bankAccounts').hide();
                        $('#sendingPhoneNumberField').show();
                    } else {
                        $('#bankAccounts').show();
                        $('#mobileBanking').hide();
                        $('#sendingPhoneNumberField').hide();
                    }
                }
            };

            window.togglePaymentDetails = function (sectionId) {
                $('.cic-payment-details').hide();
                $('#' + sectionId).toggle();
            };

        });
    </script>
    <script>
        function openModal(id) {
            $.get("{{ url('cashincashout') }}/" + id, function(data) {
            console.log(data);
            $('#transaction_number').text(data.transaction_number);
            $('#amount').text(data.amount);
            $('#status').text(data.status);
            $('#payment_method').text(data.payment_method);
            $('#sender_phone').text(data.sending_phone_number);

            $('#statusForm').attr('action', '{{ route('cashincashout.updateStatus', '') }}/' + data.id);

            $('#statusModal').modal('show');
        });
        }
    </script>
@endsection
