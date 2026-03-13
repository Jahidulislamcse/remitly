@extends('admin.layouts.app')

@section('panel')
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ $title ?? 'Create Commission' }}</h5>
            <a href="{{ route('admin.commission.index') }}" class="btn btn-primary btn-sm">Back to Commissions</a>
        </div>
    </div>

    <div class="d-flex flex-column gap-2" style="max-height:600px; overflow-y:auto;">

        <div class="card">
            <div class="card-body">

                <form action="{{ route('admin.commission.store') }}" method="POST">
                    @csrf

                    @include('backend.setting.commission.partials._form', ['button' => 'Create'])

                </form>

            </div>
        </div>

    </div>
@endsection

@push('script')
    <script type="text/javascript">
        // Custom JS can go here if needed
    </script>
@endpush