@extends('admin.layouts.app')

@section('panel')
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Payable Account</h5>
            <a href="{{ route('admin.payable_accounts.index') }}" class="btn btn-primary btn-sm">
                Back to Accounts
            </a>
        </div>
    </div>

    <!-- Optional Search Input -->
    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search accounts...">

    <div class="d-flex flex-column gap-2" style="max-height:600px; overflow-y:auto;">

        <div class="card">
            <div class="card-body d-flex flex-column gap-3">

                <form action="{{ route('admin.payable_accounts.update', $account->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Method</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ $account->name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="logo">Logo</label>
                        <input type="file" id="logo" name="logo" class="form-control">
                        @if($account->logo)
                            <img src="{{ asset($account->logo) }}" width="50" alt="Logo" class="mt-2">
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="type">Type</label>
                        <select id="type" name="type" class="form-control" required>
                            <option value="mobile_banking" {{ $account->type == 'mobile_banking' ? 'selected' : '' }}>Mobile Banking</option>
                            <option value="bank_account" {{ $account->type == 'bank_account' ? 'selected' : '' }}>Bank Account</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success mt-3">Update Account</button>
                </form>

            </div>
        </div>

    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const cards = document.querySelectorAll('.card-body');

            searchInput.addEventListener('input', function() {
                const term = this.value.toLowerCase();
                cards.forEach(card => {
                    const match = card.textContent.toLowerCase().includes(term);
                    card.closest('.card').style.display = match ? '' : 'none';
                });
            });
        });
    </script>
@endpush