@extends('admin.layouts.app')

@php
    $firstCountry = App\Models\Country::first();
@endphp


@section('panel')
    <div class="container mt-4">
        @if (session('msg'))
            <div class="alert alert-success">{{ session('msg') }}</div>
        @endif
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">{{ $title ?? 'Create User' }}</h5>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Create New User</div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.users.add') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email (optional)</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Profile Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">Optional. Allowed types: jpeg, png, jpg, gif. Max size: 2MB</small>
                    </div>

                    <div class="mb-3">

                        <label class="form-label">Country</label>

                        <select id="countrySelect"
                            class="form-control" name="location" required>

                            @foreach (App\Models\Country::all() as $country)
                                <option value="{{ $country->id }}" data-code="{{ $country->code }}"
                                    class="form-control"
                                    {{ $country->id == $firstCountry?->id ? 'selected' : '' }}>

                                    {{ $country->name }} ({{ $country->code }})

                                </option>
                            @endforeach

                        </select>

                    </div>

                    <img id="previewImage" src="#" alt="Image Preview" style="max-width:100px; display:none;" class="mb-2">

                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-control" required>
                            @foreach ($roles as $role)
                                <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                                    {{ ucfirst($role) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pin</label>
                        <input type="number" name="pin" class="form-control" required >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password (optional)</label>
                        <input type="password" name="password" class="form-control">
                        <small class="text-muted">If left blank, a random password will be generated</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Module Access</label>
                        <div class="d-flex flex-wrap">
                            @foreach ($modules as $module)
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="checkbox" name="modules[]"
                                        value="{{ $module }}"
                                        {{ in_array($module, old('modules', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label">{{ ucfirst($module) }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Create User</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    document.querySelector('input[name="image"]').addEventListener('change', function(e){
        const file = e.target.files[0];
        if(file){
            const reader = new FileReader();
            reader.onload = function(e){
                const img = document.getElementById('previewImage');
                img.src = e.target.result;
                img.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
    </script>
@endpush