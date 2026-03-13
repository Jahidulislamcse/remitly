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

<style>
    .avatar-upload {
        position: relative;
        max-width: 205px;


        .avatar-edit {
            position: absolute;

            z-index: 1;
            top: 10px;

            input {
                display: none;

                +label {
                    display: inline-block;
                    width: 34px;
                    height: 34px;
                    margin-bottom: 0;
                    border-radius: 100%;
                    background: #FFFFFF;
                    border: 1px solid transparent;
                    box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
                    cursor: pointer;
                    font-weight: normal;
                    transition: all .2s ease-in-out;

                    &:hover {
                        background: #f1f1f1;
                        border-color: #d6d6d6;
                    }

                    &:after {
                        content: "\f040";
                        font-family: 'FontAwesome';
                        color: #757575;
                        position: absolute;
                        top: 10px;
                        left: 0;
                        right: 0;
                        text-align: center;
                        margin: auto;
                    }
                }
            }
        }

        .avatar-preview {
            width: 100px;
            height: 100px;
            position: relative;
            border-radius: 100%;
            border: 6px solid #F8F8F8;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);

            >div {
                width: 100%;
                height: 100%;
                border-radius: 100%;
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
            }
        }
    }
</style>


@endsection
@section('main')

<div class="row layout-top-spacing">
    <div class="row card layout-top-spacing">

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="col-xl-12  m-5 col-lg-12 col-md-12 layout-spacing">
            <form
                action=" @if(empty($id)) {{ route('permission.create') }} @else {{ route('permission.edit',$id) }} @endif "
                method="post" class="section general-info" enctype="multipart/form-data">
                @csrf
                <div class="info">
                    <h6 class="">Role & Permission</h6>
                    <div class="row">
                        <div class="col-lg-11 mx-auto">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 mt-md-12 mt-4">
                                    <div class="form">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="fullName">Role Name</label>
                                                    <input type="text" class="form-control mb-3" id="role_name_id"
                                                        placeholder="Role Name" name="name" value="{{ @$data->name }}">
                                                </div>
                                            </div>

                                            @foreach($permissions as $permission)
                                            <div class="col-md-12 ">
                                                <div class="row" style="border-bottom: 1px solid #ccc;">
                                                    <div class="col-6 text-center">
                                                        <strong>{{$permission->name}}</strong>
                                                    </div>
                                                    <div class="col-6">

                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input type="checkbox" class="form-check-input"
                                                                    name="permissions[]" value="{{ $permission->name }}"
                                                                    @if( isset($p_ids) && !empty($p_ids) &&
                                                                    in_array($permission->id,@$p_ids)) checked
                                                                @endif>select<i class="input-helper"></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach



                                            <div class="col-md-12 mt-1">
                                                <div class="form-group text-end">
                                                    <button
                                                        class="btn btn-secondary _effect--ripple waves-effect waves-light">Save</button>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>



@endsection
@section('script')

<script>
    $("#image").change(function() {
                readlogoURL(this);
            });
function readlogoURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

</script>
<!-- These plugins only need for the run this page -->
<script src="{{ asset('admin/js/apexcharts.min.js') }} "></script>
<script src="{{ asset('admin/js/dashboard-custom.js') }} "></script>


@endsection