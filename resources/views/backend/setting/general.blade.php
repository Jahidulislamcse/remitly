@extends('admin.layouts.app')

@section('meta')
    <title>{{ $title ?? 'General Settings' }} - {{ @siteInfo()->company_name }}</title>
@endsection

@section('panel')

<div class="card mb-3">
    <div class="card-header">
        <h5 class="mb-0">{{ $title ?? 'General Settings' }}</h5>
    </div>
</div>

<div class="row">

    {{-- General Settings Form --}}
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <form action="{{ route('setting.general') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    @if($errors->any())
                        <div class="alert alert-warning">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Company Name</label>
                            <input type="text" name="company_name" class="form-control" value="{{ old('company_name', @$data->company_name) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Headquarter Address</label>
                            <input type="text" name="hq_address" class="form-control" value="{{ old('hq_address', @$data->hq_address) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Office Address</label>
                            <input type="text" name="factory_address" class="form-control" value="{{ old('factory_address', @$data->factory_address) }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', @$data->phone) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Email</label>
                            <input type="text" name="email" class="form-control" value="{{ old('email', @$data->email) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Website</label>
                            <input type="text" name="website" class="form-control" value="{{ old('website', @$data->website) }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Exchange Rate (USD)</label>
                            <input type="text" name="usd_rate" class="form-control" value="{{ old('usd_rate', @$data->usd_rate) }}">
                        </div>
                    </div>

                    <div class="row mb-3">

                        <div class="col-md-3">
                            <label>Logo</label>
                            <input type="file" class="form-control mb-2" id="logoInput" name="logo">
                            <img id="logoPreview" src="{{ @$data->logo ? asset($data->logo) : '' }}" style="max-width:100px; display:{{ @$data->logo ? 'block':'none' }}">
                        </div>

                        <div class="col-md-3">
                            <label>Icon</label>
                            <input type="file" class="form-control mb-2" id="iconInput" name="icon">
                            <img id="iconPreview" src="{{ @$data->icon ? asset($data->icon) : '' }}" style="max-width:100px; display:{{ @$data->icon ? 'block':'none' }}">
                        </div>

                        <div class="col-md-3">
                            <label>Status</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" value="1" id="statusActive" {{ @$data->status==1 || empty($data) ? 'checked':'' }}>
                                <label class="form-check-label" for="statusActive">Active</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" value="0" id="statusInactive" {{ @$data->status===0 ? 'checked':'' }}>
                                <label class="form-check-label" for="statusInactive">Deactive</label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label>Block Bangladesh & VPN</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="block_bd_vpn" id="blockBDVPN" {{ @$data->block_bd_vpn ? 'checked':'' }}>
                            </div>
                        </div>

                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Save Settings</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

</div>

@endsection

@push('script')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Logo preview
    const logoInput = document.getElementById('logoInput');
    const logoPreview = document.getElementById('logoPreview');
    logoInput.addEventListener('change', function(){
        const file = this.files[0];
        if(file){
            const reader = new FileReader();
            reader.onload = function(e){
                logoPreview.src = e.target.result;
                logoPreview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });

    // Icon preview
    const iconInput = document.getElementById('iconInput');
    const iconPreview = document.getElementById('iconPreview');
    iconInput.addEventListener('change', function(){
        const file = this.files[0];
        if(file){
            const reader = new FileReader();
            reader.onload = function(e){
                iconPreview.src = e.target.result;
                iconPreview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });

});
</script>
@endpush