@extends('admin.layouts.app')

@section('meta')
    <title>{{ $title ?? 'Slider' }} - {{ @siteInfo()->company_name }}</title>
@endsection

@section('panel')

<div class="card mb-3">
    <div class="card-header">
        <h5 class="mb-0">{{ $title ?? 'Slider' }}</h5>
    </div>
</div>

<div class="row">

    {{-- Slider Form --}}
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">

                <form action="@if(empty(@$data)) {{ route('slider') }} @else {{ route('slider.edit',$data->id) }}  @endif"
                      method="post" enctype="multipart/form-data">
                    @csrf

                    @if($errors->any())
                        <div class="alert alert-warning">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">{{ __("Image") }} <span class="text-danger">*</span></label>
                        <input type="file" name="image" class="form-control" id="imageInput">

                        @if (@$data->image)
                            <div class="mt-2">
                                <strong>Current Preview:</strong><br>
                                <img src="{{ asset(@$data->image) }}" id="imagePreview" width="100" style="object-fit:contain">
                            </div>
                        @else
                            <div class="mt-2">
                                <img id="imagePreview" width="100" style="object-fit:contain; display:none;">
                            </div>
                        @endif
                    </div>

                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-primary">{{ __("Save") }}</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    {{-- Slider List --}}
    <div class="col-md-8">

        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search sliders...">

        <div class="d-flex flex-column gap-2" style="max-height:600px; overflow-y:auto;">

            @forelse($list as $li)
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">

                        <div>
                            <img src="{{ asset(@$li->image) }}" alt="Slider" width="100" style="object-fit:contain">
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('slider.edit',$li->id) }}" class="btn btn-sm btn-primary">
                                <i class="fa fa-edit"></i>
                            </a>

                            <a href="{{ route('slider.delete',$li->id) }}" class="btn btn-sm btn-danger"
                               onclick="return confirm('Delete slider?')">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">
                    No sliders found
                </div>
            @endforelse

        </div>

    </div>

</div>

@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Search filter
    const searchInput = document.getElementById('searchInput');
    const cards = document.querySelectorAll('.col-md-8 .card-body');

    searchInput.addEventListener('input', function() {
        const term = this.value.toLowerCase();
        cards.forEach(card => {
            const match = card.textContent.toLowerCase().includes(term);
            card.closest('.card').style.display = match ? '' : 'none';
        });
    });

    // Image preview
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