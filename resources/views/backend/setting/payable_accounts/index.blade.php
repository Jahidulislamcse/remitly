@extends('admin.layouts.app')

@section('panel')
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Payable Accounts</h5>

            <a href="{{ route('admin.payable_accounts.create') }}" class="btn btn-primary btn-sm">
                Create New Account
            </a>
        </div>
    </div>

    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search accounts...">

    <div class="d-flex flex-column gap-2" style="max-height:600px; overflow-y:auto;">

        @forelse ($accounts as $account)
            <div class="card">

                <div class="card-body d-flex justify-content-between align-items-center">

                    <div class="d-flex align-items-center gap-3">

                        @if ($account->logo)
                            <img src="{{ asset($account->logo) }}" width="40" height="40" style="object-fit:contain">
                        @endif

                        <div>
                            <div><strong>{{ $account->name }}</strong></div>
                            <div class="text-muted small">Type: {{ $account->type }}</div>
                        </div>

                    </div>

                    <div>

                        <a href="{{ route('admin.payable_accounts.edit', $account->id) }}" class="btn btn-sm btn-warning">
                            <i class="fa fa-edit"></i>
                        </a>

                        <form action="{{ route('admin.payable_accounts.destroy', $account->id) }}" method="POST"
                            style="display:inline-block"
                            onsubmit="return confirm('Are you sure you want to delete this account?');">

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        @empty

            <div class="text-center py-5 text-muted">
                No payable accounts found
            </div>
        @endforelse

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
