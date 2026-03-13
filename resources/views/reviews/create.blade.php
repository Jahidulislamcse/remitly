@extends('admin.layouts.app')

@section('meta')
<title>{{ $title ?? 'Reviews Management' }} - {{ @siteInfo()->company_name }}</title>
@endsection

@section('panel')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5>{{ $title ?? 'Reviews Management' }}</h5>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createReviewModal">
        Upload Review
    </button>
</div>

{{-- Reviews Grid --}}
<div class="row" id="reviewsContainer">
    @forelse($reviews as $review)
    <div class="col-lg-4 col-md-6 col-sm-12 mb-4 review-card">
        <div class="card h-100 @if($review->status == 0) border-warning @endif">
            <div class="card-header">
                {{ $review->title }}
                @if($review->status == 0)
                <span class="badge bg-warning text-dark ms-2">Pending</span>
                @endif
            </div>
            <div class="card-body d-flex flex-column gap-2">

                @if($review->video_path)
                <div class="mb-2" style="height:180px; overflow:hidden;">
                    <video width="100%" height="100%" controls style="object-fit:contain;">
                        <source src="{{ asset($review->video_path) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
                @endif

                <p>{{ Str::limit($review->description, 120) }}</p>

                <div class="mt-auto d-flex flex-wrap gap-2">
                    @if($review->user_id == auth()->id())
                    <button class="btn btn-sm btn-primary edit-review"
                        data-bs-toggle="modal" 
                        data-bs-target="#editReviewModal"
                        data-id="{{ $review->id }}"
                        data-title="{{ $review->title }}"
                        data-description="{{ $review->description }}"
                        data-video="{{ $review->video_path ? asset($review->video_path) : '' }}">
                        <i class="fa fa-edit"></i> Edit
                    </button>
                    @endif

                    <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</button>
                    </form>

                    @if($review->status == 0)
                    <form action="{{ route('reviews.approve', $review->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm btn-success">Approve</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="text-center text-muted py-5 col-12">
        No reviews found.
    </div>
    @endforelse
</div>

<div class="d-flex justify-content-center mt-3">
    {{ $reviews->links('pagination::bootstrap-5') }}
</div>

{{-- Create Review Modal --}}
<div class="modal fade" id="createReviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="createReviewForm" action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Video</label>
                        <input type="file" name="video_path" class="form-control" accept="video/*" id="createVideoInput" required>
                        <small class="text-muted">Supported: mp4, mov, avi, webm | Max 50MB</small>
                        <div class="mt-2">
                            <video id="createVideoPreview" width="100%" height="200" controls style="display:none; object-fit:contain;"></video>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Review Modal --}}
<div class="modal fade" id="editReviewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="updateReviewFormElement" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="update_review_id" name="review_id">
                <div class="modal-header">
                    <h5 class="modal-title">Update Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" id="update_title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Video</label>
                        <input type="file" name="video_path" class="form-control" id="update_video_path" accept="video/*">
                        <small class="text-muted">Supported: mp4, mov, avi, webm | Max 50MB</small>
                        <div class="mt-2">
                            <video id="updateVideoPreview" width="100%" height="200" controls style="display:block; object-fit:contain;"></video>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" id="update_description" rows="4" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Review</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
document.addEventListener("DOMContentLoaded", function () {

    // Create video preview
    const createVideoInput = document.getElementById('createVideoInput');
    const createVideoPreview = document.getElementById('createVideoPreview');
    createVideoInput.addEventListener('change', function () {
        const file = this.files[0];
        if(file){
            createVideoPreview.src = URL.createObjectURL(file);
            createVideoPreview.style.display = 'block';
        }
    });

    // Edit modal
    const editModal = document.getElementById('editReviewModal');
    const updateForm = document.getElementById('updateReviewFormElement');
    const updateTitle = document.getElementById('update_title');
    const updateDescription = document.getElementById('update_description');
    const updateVideoPreview = document.getElementById('updateVideoPreview');
    const updateVideoInput = document.getElementById('update_video_path');
    const updateIdInput = document.getElementById('update_review_id');

    document.querySelectorAll('.edit-review').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            const title = this.dataset.title;
            const description = this.dataset.description;
            const video = this.dataset.video;

            updateIdInput.value = id;
            updateTitle.value = title;
            updateDescription.value = description;

            if(video){
                updateVideoPreview.src = video;
                updateVideoPreview.style.display = 'block';
            } else {
                updateVideoPreview.style.display = 'none';
            }

            updateForm.action = `/reviews/${id}`;
        });
    });

    // Update modal video preview
    updateVideoInput.addEventListener('change', function(){
        const file = this.files[0];
        if(file){
            updateVideoPreview.src = URL.createObjectURL(file);
            updateVideoPreview.style.display = 'block';
        }
    });

});
</script>
@endpush