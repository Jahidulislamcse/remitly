@extends('admin.layouts.app')

@section('panel')
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ $title ?? 'Commission List' }}</h5>
            <a href="{{ route('admin.commission.create') }}" class="btn btn-primary btn-sm">Add Commission</a>
        </div>
    </div>

    <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search commissions...">

    <div class="d-flex flex-column gap-2" style="max-height:600px; overflow-y:auto;">

        @forelse ($commitions as $commission)
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">

                    <div>
                        <div><strong>{{ $commission->type }}</strong></div>
                        <div class="text-muted small">Percentage: {{ rtrim(rtrim(number_format($commission->percentage, 2, '.', ''), '0'), '.') }}%</div>
                        <div class="text-muted small">Created: {{ $commission->created_at?->format('Y-m-d') }}</div>
                    </div>

                    <div>
                        <a href="{{ route('admin.commission.edit', $commission) }}" class="btn btn-sm btn-warning">
                            <i class="fa fa-edit"></i>
                        </a>

                        <form action="{{ route('admin.commission.destroy', $commission) }}" method="POST"
                              style="display:inline-block"
                              onsubmit="return confirm('Are you sure you want to delete this commission?');">
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
                No commissions found
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