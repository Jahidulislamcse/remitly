@extends('frontend.layout.master')


@section('main')
    <div class="service-area pt_80 pb_80" id="services">
        <div class="container wow fadeIn">

            <div class="row">

                <div class="col-md-12">
                    <div class="form-group">

                        <h1 class="text-center">Pay = {{ number_format($data->advanceAmount(), 2) }} TK</h1>
                    </div>
                </div>

                <form id="paymentForm" action="{{ route('payment.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <input type="hidden" name="paid" value="{{ $data->advanceAmount() }}">
                    <div class="row" style="  justify-content: center;   ">
                        <h3 class="text-center">Payment Method</h3>
                        @error('payment_method')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                        <div class=" col-3 ">
                            <label class="radio-container">
                                <input name="payment_method" onclick="showDetails()" value="bkash" id="bkash"
                                    type="radio" class="radio-hidden">
                                <img src="{{ asset('fileManager/bkash.png') }}" class="radio-image">
                            </label>
                            <br>
                            <p style=" font-size: 24px; text-align: center; "> Bkash</p>
                        </div>
                        <div class=" col-3 ">
                            <label class="radio-container">
                                <input name="payment_method" value="nagad" onclick="showDetails()" id="nagad"
                                    type="radio" class="radio-hidden">
                                <img src="{{ asset('fileManager/nagad.avif') }}" class="radio-image">
                            </label>
                            <br>
                            <p style=" font-size: 24px; text-align: center; "> Nagad </p>

                        </div>
                        <div class=" col-3 ">
                            <label class="radio-container">
                                <input name="payment_method" onclick="showDetails()" value="bank" id="bank"
                                    type="radio" class="radio-hidden">
                                <img src="{{ asset('fileManager/bank.jpg') }}" class="radio-image">
                            </label>
                            <br>
                            <p style=" font-size: 24px; text-align: center; "> Bank</p>
                        </div>
                    </div>
                    <div id="details"
                        style="
                    background: #acdfa4;
                    padding: 50px;
                    font-size: 24px;
                    text-align: center;
                "
                        class="description d-none"></div>

                    <div class="form-group mt-5">
                        <label for="">Upload Your Payment Screenshot</label>
                        <input type="file" class="form-control" name="payment_screenshot">
                        @error('payment_screenshot')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-center mt-5">
                        <button class="btn btn-info">Back</button>
                        <button type="submit" class="btn btn-success">Payment Complete</button>
                    </div>



                </form>




            </div>
        </div>
    </div>



    <script>
        function showDetails() {
            const detailsDiv = document.getElementById('details');
            detailsDiv.classList.remove('d-none');
            if (document.getElementById('bkash').checked) {
                detailsDiv.innerHTML = 'Personal - 01727038000 (Send Money)';
            } else if (document.getElementById('nagad').checked) {
                detailsDiv.innerHTML = 'Personal - 01727038000 (Send Money)';
            } else if (document.getElementById('bank').checked) {
                detailsDiv.innerHTML =
                    'Bank Name: The City Bank <br> Account Holder Name: Moono Technology  <br> Account Number: 1502922959001 <br> Routing Number-225264634 <br>  Branch Name: Uttara  <br>';
            }
        }
    </script>
@endsection
