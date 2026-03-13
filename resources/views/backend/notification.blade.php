@extends('admin.layouts.app')

@php
    $pageTitle = isset($title) ? $title : 'Deposits';
@endphp

@section('panel')
<div class="card mb-3">
    <div class="card-header">
        <h5 class="mb-0">Notification</h5>
    </div>
</div>

<div class="row">

    {{-- Notification Form --}}
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <form
                    action="@if (empty(@$notification)) {{ route('notifications.store') }} @else {{ route('notifications.update', $notification->id) }} @endif"
                    method="post">

                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-warning">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Message <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="5" name="message">{{ old('title', @$notification->message) }}</textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- Notification List --}}
    <div class="col-md-8">

        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search notifications...">

        {{-- Scrollable list container --}}
        <div class="d-flex flex-column gap-2" style="max-height: 600px; overflow-y: auto;">

            @forelse($list as $li)
                <div class="card">

                    <div class="card-body d-flex justify-content-between align-items-center">

                        <div>
                            <div><strong>Message:</strong> {{ $li->message }}</div>
                            @if ($li->created_at)
                                <div class="text-muted small">{{ $li->created_at->format('d M Y H:i') }}</div>
                            @endif
                        </div>

                        <div>
                            <a href="{{ route('notifications.edit', $li->id) }}" class="btn btn-sm btn-primary">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="{{ route('notifications.delete', $li->id) }}" class="btn btn-sm btn-danger"
                               onclick="return confirm('Delete notification?')">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>

                    </div>

                </div>
            @empty
                <div class="text-center py-5 text-muted">
                    No notifications found
                </div>
            @endforelse

        </div>

    </div>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    const searchInput = document.getElementById('searchInput');
    const cards = document.querySelectorAll('.col-md-8 .card-body');

    searchInput.addEventListener('input', function() {

        const term = this.value.toLowerCase();

        cards.forEach(card => {
            const match = card.textContent.toLowerCase().includes(term);
            card.closest('.card').style.display = match ? '' : 'none';
        });

    });

});
</script>
@endsection