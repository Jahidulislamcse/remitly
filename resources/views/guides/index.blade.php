@extends('admin.layouts.app')

@section('panel')
    <h3 class="mb-3">App Guide</h3>


    @if ($guide)
        <div class="list-cards" style="max-height: 600px; overflow-y: auto;">
            @php
                $sections = [
                    'Mobile Deposit' => $guide->mobile_deposit,
                    'Mobile Menual Deposit' => $guide->mobile_menual_deposit,
                    'Bank Deposit' => $guide->bank_deposit,
                    'Customer Care' => $guide->customer_care,
                    'Cash Pickup' => $guide->cash_pickup,
                    'Loan' => $guide->loan,
                    'Remittance' => $guide->remittance,
                    'How to Add Balance' => $guide->how_to_balance_add,
                    'How to Bank Transfer' => $guide->how_to_bank_transfer,
                    'How to Use Mobile Banking' => $guide->how_to_mobile_banking,
                    'About Us' => $guide->about_us,
                ];
            @endphp

            @foreach ($sections as $title => $content)
                <div class="topup-card mb-2">
                    <div class="topup-slot">
                        <div class="topup-user"><strong>{{ $title }}</strong></div>
                        <div class="topup-phone">{!! $content !!}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 mb-4">
            <a href="{{ route('guides.edit', $guide->id) }}" class="btn btn-primary" style="width: 150px;">
                Update
            </a>
        </div>
    @else
        <div class="col-12 text-center py-5">
            <img src="{{ asset('assets/images/empty_box.png') }}" width="120">
            <p class="mt-3 text-muted">No guide information available</p>
            <a href="{{ route('guides.create') }}" class="btn btn-success">Create Guide</a>
        </div>
    @endif
@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const cards = document.querySelectorAll('.list-cards .topup-card');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        cards.forEach(card => {
            const matches = card.textContent.toLowerCase().includes(searchTerm);
            card.style.display = matches ? '' : 'none';
        });
    });

    tinymce.init({
        selector: 'textarea',
        plugins: 'lists link image table code emoticons',
        toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | outdent indent | link image emoticons code',
        menubar: false,
    });
});
</script>
@endpush