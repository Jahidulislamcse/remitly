@extends('admin.layouts.app')

@section('meta')
    <title>{{ $title ?? 'Content' }} - {{ @siteInfo()->company_name }}</title>
@endsection

@section('panel')

<div class="card mb-3">
    <div class="card-header">
        <h5 class="mb-0">{{ $title ?? 'Content Management' }}</h5>
    </div>
</div>

<div class="row">

    {{-- Page Form --}}
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">

                <form action="@if(empty(@$page)) {{ route('page') }} @else {{ route('page.edit',@$page->id) }}  @endif"
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
                        <label class="form-label">{{ __("Page") }} <span class="text-danger">*</span></label>
                        <select name="key" class="form-control">
                            <option value="terms" @if(@$page->key === "terms") selected @endif>শর্তাবলী</option>
                            <option value="about" @if(@$page->key === "about") selected @endif>আমাদের সম্পর্কে</option>
                            <option value="agreement" @if(@$page->key === "agreement") selected @endif>অঙ্গীকারনামা</option>
                            <option value="topup" @if(@$page->key === "topup") selected @endif>অ্যাড ফান্ড</option>
                            <option value="topup bank" @if(@$page->key === "topup bank") selected @endif>অ্যাড ব্যাংক ফান্ড</option>
                            <option value="mobile recharge" @if(@$page->key === "mobile recharge") selected @endif>মোবাইল রিচার্জ</option>
                            <option value="bill pay" @if(@$page->key === "bill pay") selected @endif>বিল পে</option>
                            <option value="bank pay" @if(@$page->key === "bank pay") selected @endif>ব্যাংক পে</option>
                            <option value="bkash" @if(@$page->key === "bkash") selected @endif>বিকাশ</option>
                            <option value="rocket" @if(@$page->key === "rocket") selected @endif>রকেট</option>
                            <option value="nagad" @if(@$page->key === "nagad") selected @endif>নগদ</option>
                            <option value="upay" @if(@$page->key === "upay") selected @endif>উপায়</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __("File") }} <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="files[]" multiple>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __("Content") }} <span class="text-danger">*</span></label>
                        <textarea class="form-control ckeditor" rows="5" name="value">{{ old('value', @$page->value) }}</textarea>
                    </div>

                    <div class="d-grid mt-3">
                        <button type="submit" class="btn btn-primary">{{ __("Save") }}</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    {{-- Page List --}}
    <div class="col-md-8">

        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search content...">

        <div class="d-flex flex-column gap-2" style="max-height:600px; overflow-y:auto;">

            @forelse($list as $li)
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">

                        <div>
                            <div><strong>{{ @$li->key }}</strong></div>
                            <div class="text-muted small">{!! Str::limit(@$li->value, 100) !!}</div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ route('page.edit',$li->id) }}" class="btn btn-sm btn-primary">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="{{ route('page.delete',$li->id) }}" class="btn btn-sm btn-danger"
                               onclick="return confirm('Delete content?')">
                                <i class="fa fa-trash"></i>
                            </a>
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">
                    No content found
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

    // Initialize CKEditor if not already initialized
    if (typeof CKEDITOR !== 'undefined') {
        CKEDITOR.replaceAll('ckeditor');
    }

});
</script>
@endpush