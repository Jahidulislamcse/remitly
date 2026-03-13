@extends('admin.layouts.app')

@section('meta')
<title>{{ isset($title) ? $title : 'Color Settings' }} - {{ @siteInfo()->company_name }}</title>
@endsection

@section('panel')
<div class="container py-4">

    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ $title ?? 'Website Theme Settings' }}</h5>
            <button type="submit" form="colorSettingsForm" class="btn btn-primary btn-sm">Update</button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.colors.update') }}" method="POST" id="colorSettingsForm">
        @csrf
        @method('PUT')

        <div class="row g-3">

            <div class="col-md-4">
                <label class="form-label">Background (Body)</label>
                <div class="d-flex gap-2 align-items-center">
                    <input type="color" class="picker form-control form-control-color" value="{{ old('body_color', $colors->body_color ?? '#ffffff') }}">
                    <input type="text" name="body_color" class="hex-input form-control" value="{{ old('body_color', $colors->body_color ?? '#ffffff') }}">
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Header Theme</label>
                <div class="d-flex gap-2 align-items-center">
                    <input type="color" class="picker form-control form-control-color" value="{{ old('header_color', $colors->header_color ?? '#067fab') }}">
                    <input type="text" name="header_color" class="hex-input form-control" value="{{ old('header_color', $colors->header_color ?? '#067fab') }}">
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Footer Theme</label>
                <div class="d-flex gap-2 align-items-center">
                    <input type="color" class="picker form-control form-control-color" value="{{ old('footer_color', $colors->footer_color ?? '#333333') }}">
                    <input type="text" name="footer_color" class="hex-input form-control" value="{{ old('footer_color', $colors->footer_color ?? '#333333') }}">
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Headings (h1 - h6)</label>
                <div class="d-flex gap-2 align-items-center">
                    <input type="color" class="picker form-control form-control-color" value="{{ old('headings_color', $colors->headings_color ?? '#000000') }}">
                    <input type="text" name="headings_color" class="hex-input form-control" value="{{ old('headings_color', $colors->headings_color ?? '#000000') }}">
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Heading Background</label>
                <div class="d-flex gap-2 align-items-center">
                    <input type="color" class="picker form-control form-control-color" value="{{ old('heading_background_color', $colors->heading_background_color ?? '#f8fafc') }}">
                    <input type="text" name="heading_background_color" class="hex-input form-control" value="{{ old('heading_background_color', $colors->heading_background_color ?? '#f8fafc') }}">
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Input Labels</label>
                <div class="d-flex gap-2 align-items-center">
                    <input type="color" class="picker form-control form-control-color" value="{{ old('label_color', $colors->label_color ?? '#475569') }}">
                    <input type="text" name="label_color" class="hex-input form-control" value="{{ old('label_color', $colors->label_color ?? '#475569') }}">
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label">Text / Paragraph (p)</label>
                <div class="d-flex gap-2 align-items-center">
                    <input type="color" class="picker form-control form-control-color" value="{{ old('paragraph_color', $colors->paragraph_color ?? '#1e293b') }}">
                    <input type="text" name="paragraph_color" class="hex-input form-control" value="{{ old('paragraph_color', $colors->paragraph_color ?? '#1e293b') }}">
                </div>
            </div>

        </div>

    </form>

</div>
@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const pickers = document.querySelectorAll('.picker');
    const hexInputs = document.querySelectorAll('.hex-input');

    pickers.forEach((picker, i) => {
        picker.addEventListener('input', function() {
            hexInputs[i].value = this.value.toUpperCase();
        });
    });

    hexInputs.forEach((input, i) => {
        input.addEventListener('input', function() {
            let code = this.value;
            if (!code.startsWith('#')) code = '#' + code;
            if (/^#[0-9A-F]{6}$/i.test(code)) pickers[i].value = code;
        });
    });
});
</script>
@endpush