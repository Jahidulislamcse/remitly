@extends('admin.layouts.app')

@section('panel')
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Create Payable Account</h5>
            <a href="{{ route('admin.payable_accounts.index') }}" class="btn btn-primary btn-sm">
                Back to Accounts
            </a>
        </div>
    </div>

    <div class="d-flex flex-column gap-2" style="max-height:600px; overflow-y:auto;">

        <div class="card">
            <div class="card-body d-flex flex-column gap-3">

                <form action="{{ route('admin.payable_accounts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="name">Method</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="logo">Logo</label>
                        <input type="file" id="logo" name="logo" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="type">Type</label>
                        <select id="type" name="type" class="form-control" required>
                            <option value="">Select Account Type</option>
                            <option value="mobile_banking">Mobile Banking</option>
                            <option value="bank_account">Bank Account</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success mt-3">Create Account</button>
                </form>

            </div>
        </div>

    </div>
@endsection

@push('script')
    <!-- Add any JS if needed -->
@endpush