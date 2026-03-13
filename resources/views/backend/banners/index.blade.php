@extends('admin.layouts.app')

@section('meta')
<title>{{ $title ?? 'Banners' }} - {{ @siteInfo()->company_name }}</title>
@endsection

@section('panel')

<div class="card mb-3">
    <div class="card-header">
        <h5 class="mb-0">{{ $title ?? 'Banners' }}</h5>
    </div>
</div>

<div class="row">

    {{-- Banner Form --}}
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">

                <form
                    action="@if(empty($data)) {{ route('admin.banners.store') }} @else {{ route('admin.banners.update', $data->id) }} @endif"
                    method="post" enctype="multipart/form-data">

                    @csrf
                    @if(!empty($data)) @method('PUT') @endif

                    @if ($errors->any())
                        <div class="alert alert-warning">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input class="form-control" name="title" value="{{ old('title', @$data->title) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input class="form-control" type="file" name="image" id="imageInput">

                        @if(!empty(@$data->image))
                            <div class="mt-2">
                                <strong>Current Preview:</strong><br>
                                <img src="{{ asset($data->image) }}" id="imagePreview" width="80" style="object-fit:contain">
                            </div>
                        @else
                            <div class="mt-2">
                                <img id="imagePreview" width="80" style="object-fit:contain; display:none;">
                            </div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3">{{ old('description', @$data->description) }}</textarea>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">@if(empty($data)) Upload @else Update @endif</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    {{-- Banner List --}}
    <div class="col-md-8">

        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search banners...">

        <div class="d-flex flex-column gap-2" style="max-height:600px; overflow-y:auto;">

            @forelse ($banners as $banner)
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">

                        <div class="d-flex align-items-center gap-3">
                            @if($banner->image)
                                <img src="{{ asset($banner->image) }}" alt="Banner" width="50" height="35" style="object-fit:contain">
                            @endif
                            <div>
                                <div><strong>{{ $banner->title }}</strong></div>
                                <div class="text-muted small">{{ Str::limit($banner->description, 40) }}</div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-sm btn-primary">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete banner?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">
                    No banners found
                </div>
            @endforelse

        </div>

    </div>

</div>

@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Search
    const searchInput = document.getElementById('searchInput');
    const cards = document.querySelectorAll('.col-md-8 .card-body');

    searchInput.addEventListener('input', function() {
        const term = this.value.toLowerCase();
        cards.forEach(card => {
            const match = card.textContent.toLowerCase().includes(term);
            card.closest('.card').style.display = match ? '' : 'none';
        });
    });

    // Image preview for form
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

    // Edit banner dynamically
    document.querySelectorAll('.col-md-8 .btn-primary').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('href');

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // Prefill form
                    const form = document.querySelector('.col-md-4 form');
                    form.setAttribute('action', `/admin/banners/${data.id}`);
                    if(!form.querySelector('input[name="_method"]')) {
                        const methodInput = document.createElement('input');
                        methodInput.setAttribute('type', 'hidden');
                        methodInput.setAttribute('name', '_method');
                        methodInput.setAttribute('value', 'PUT');
                        form.appendChild(methodInput);
                    }

                    form.querySelector('input[name="title"]').value = data.title;
                    form.querySelector('textarea[name="description"]').value = data.description;

                    // Show existing image
                    imagePreview.src = `{{ asset('') }}${data.image}`;
                    imagePreview.style.display = 'block';
                })
                .catch(err => console.error('Error fetching banner:', err));
        });
    });

});
</script>
@endpush