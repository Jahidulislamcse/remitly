@extends('admin.layouts.app')

@section('meta')
    <title>{{ $title ?? 'Countries with Exchange Rate' }} - {{ @siteInfo()->company_name }}</title>
@endsection

@section('panel')

<div class="card mb-3">
    <div class="card-header">
        <h5 class="mb-0">{{ $title ?? 'Countries with Exchange Rate' }}</h5>
    </div>
</div>

<div class="row">

    {{-- Country Form --}}
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">

                <form
                    action="@if (empty(@$data)) {{ route('country') }} @else {{ route('country.edit', $data->id) }} @endif"
                    method="post" enctype="multipart/form-data">

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
                        <label class="form-label">{{ __('Code') }}</label>
                        <input class="form-control" name="code" value="{{ old('code', @$data->code) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('Rate') }}</label>
                        <input class="form-control" name="rate" value="{{ old('rate', @$data->rate) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('Currency') }}</label>
                        <input class="form-control" name="currency" value="{{ old('currency', @$data->currency) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('Flag Image') }}</label>
                        <input class="form-control" type="file" name="image" id="imageInput">

                        @if(!empty(@$data->image))
                            <div class="mt-2">
                                <strong>Current Preview:</strong><br>
                                <img src="{{ asset(@$data->image) }}" id="imagePreview" width="80" style="object-fit:contain">
                            </div>
                        @else
                            <div class="mt-2">
                                <img id="imagePreview" width="80" style="object-fit:contain; display:none;">
                            </div>
                        @endif
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    {{-- Country List --}}
    <div class="col-md-8">

        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search countries...">

        <div class="d-flex flex-column gap-2" style="max-height:600px; overflow-y:auto;">

            @forelse ($list as $li)
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">

                        <div class="d-flex align-items-center gap-3">
                            @if($li->image)
                                <img src="{{ asset($li->image) }}" alt="Flag" width="50" height="35" style="object-fit:contain">
                            @endif
                            <div>
                                <div><strong>{{ $li->name }} ({{ $li->code }})</strong></div>
                                <div class="text-muted small">Rate: {{ $li->rate }}</div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('country.edit', $li->id) }}" class="btn btn-sm btn-primary">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="{{ route('country.delete', $li->id) }}" class="btn btn-sm btn-danger"
                               onclick="return confirm('Delete country?')">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">
                    No countries found
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

    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');

    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });

});
</script>
@endpush