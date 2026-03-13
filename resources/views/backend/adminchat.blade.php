@extends('backend.adminLayout.master')
@section('meta')

<title>{{ isset($title)?$title:'welcome' }} - {{ @siteInfo()->company_name }}</title>


@endsection
@section('style')




@endsection
@section('main')
<div class="card">
    <div class="card-header">
        <div class="breadcrumb-header">
            <h5>{{ __("Group Chat") }}</h5>
        </div>

    </div>
</div>
<div class="row">
    
    @livewire('chat')

</div>




@endsection
@section('script')
<script>
    let table = new DataTable('#myTable');
</script>

<!-- These plugins only need for the run this page -->
<script src="{{ asset('admin/js/apexcharts.min.js') }} "></script>
<script src="{{ asset('admin/js/dashboard-custom.js') }} "></script>


@endsection