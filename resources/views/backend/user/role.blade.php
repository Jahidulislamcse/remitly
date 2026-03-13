@extends('backend.layout.master')
@section('meta')

<title>{{ isset($title)?$title:'welcome' }} - {{ env('APP_NAME') }}</title>

<link rel="canonical" href="{{ route('user.index') }}" />
<meta name="description"
    content="&lt;p&gt;Discover the power of residential proxies and RDP services at IPMela.com. Unmatched reliability and performance for your online needs.&lt;/p&gt;" />
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="article" />
<meta property="og:title" content="Worldsocks5 LTD" />
<meta property="og:description"
    content="&lt;p&gt;Discover the power of residential proxies and RDP services at IPMela.com. Unmatched reliability and performance for your online needs.&lt;/p&gt;" />
<meta property="og:url" content="{{ route('user.index') }}" />
<meta property="og:site_name" content="Worldsocks5 LTD" />
<meta property="article:publisher" content="#" />
<meta property="og:image" content="admin/uploads/settings/1717613677.png" />


@endsection
@section('style')




@endsection
@section('main')

<div class="row layout-top-spacing">

    <div class="row">
        <a href="{{ route('permission.create') }}" class="btn btn-primary" style="float: right">New Permission</a>
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">

                    <table id="individual-col-search" class="table dt-table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lists as $list)
                            <tr>
                                <td>{!! @$list->id !!}</td>
                                <td>{!! @$list->name !!}</td>
                                <td class="text-center">
                                    <a class="btn btn-primary  btn-small"
                                        href="{{ route('permission.edit',$list->id) }}">Edit</a>
                                    <a class="btn btn-info  btn-small"
                                        href="{{ route('permission.delete',$list->id) }}">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>



</div>

@endsection
@section('script')


<!-- These plugins only need for the run this page -->
<script src="{{ asset('admin/js/apexcharts.min.js') }} "></script>
<script src="{{ asset('admin/js/dashboard-custom.js') }} "></script>


@endsection