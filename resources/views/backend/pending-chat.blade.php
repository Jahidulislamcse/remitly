@extends('backend.adminLayout.master')
@section('meta')

<title>{{ isset($title)?$title:'welcome' }} - {{ @siteInfo()->company_name }}</title>



@endsection
@section('style')




@endsection
@section('main')

    @livewire('pending-chat')


@endsection

@section('script')
<script type="text/javascript">
    let table = new DataTable('#product');
 
</script>




@endsection