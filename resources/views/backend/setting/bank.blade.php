@extends('admin.layouts.app')

@section('panel')

<div class="card mb-3">
    <div class="card-header">
        <h5 class="mb-0">Receival Bank Accounts</h5>
    </div>
</div>

<div class="row">

    {{-- Bank Form --}}
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">

                <form
                    action="@if (empty(@$data)) {{ route('bank') }} @else {{ route('bank.edit', $data->id) }} @endif"
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
                        <label class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                        <input class="form-control" name="name" value="{{ old('name', @$data->name) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('Details') }}</label>
                        <textarea class="form-control ckeditor" rows="5" name="details">{{ old('details', @$data->details) }}</textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Save') }}
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>


    {{-- Bank List --}}
    <div class="col-md-8">

        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search bank...">

        {{-- Scrollable list --}}
        <div class="d-flex flex-column gap-2" style="max-height:600px; overflow-y:auto;">

            @forelse($list as $li)

                <div class="card">

                    <div class="card-body d-flex justify-content-between align-items-center">

                        <div>
                            <div><strong>{{ $li->name }}</strong></div>

                            @if ($li->details)
                                <div class="text-muted small">{!! $li->details !!}</div>
                            @endif
                        </div>

                        <div>

                            <a href="{{ route('bank.edit', $li->id) }}" class="btn btn-sm btn-primary">
                                <i class="fa fa-edit"></i>
                            </a>

                            <span
                                data="{{ route('bank.delete', $li->id) }}"
                                class="btn btn-sm btn-danger delete-btn">
                                <i class="fa fa-trash"></i>
                            </span>

                        </div>

                    </div>

                </div>

            @empty

                <div class="text-center py-5 text-muted">
                    No bank records found
                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection


@push('script')
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
@endpush