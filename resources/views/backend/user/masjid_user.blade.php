@extends('backend.layout.master')
@section('meta')

<title>{{ isset($title)?$title:'welcome' }} - {{ env('APP_NAME') }}</title>

<link rel="canonical" href="{{ route('user.index') }}" />



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
            <form action=" @if(empty($id)) {{ route('user.masjid') }} @else {{ route('user.masjid.edit',$id) }} @endif "
                method="post" class="section general-info" enctype="multipart/form-data">
                @csrf
                <div class="info">
                    <h6 class="">General Information</h6>
                    <div class="row">
                        <div class="col-lg-11 mx-auto">
                            <div class="row">
                                <div class="col-xl-2 col-lg-12 col-md-4">
                                    <div class="profile-image  mt-4 pe-md-4">

                                        <div class="avatar-upload">
                                            <div class="avatar-edit">
                                                <input type='file' id="image" name="image" accept=".png, .jpg, .jpeg" />
                                                <label for="image"></label>
                                            </div>
                                            <div class="avatar-preview">
                                                <div id="imagePreview"
                                                    style="background-image: url(@if(@$data->image) {{ asset(@$data->image) }} @else  https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/330px-No-Image-Placeholder.svg.png?20200912122019 @endif);">
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                    <div class="form">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fullName">Employe ID</label>
                                                    <input type="text" class="form-control mb-3" id="employee_id"
                                                        placeholder="Employe Id" name="employee_id"
                                                        value="{{ @$data->employee_id }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fullName">Full Name</label>
                                                    <input type="text" class="form-control mb-3" id="fullName"
                                                        placeholder="Full Name" name="name" value="{{ @$data->name }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="profession">User Name</label>
                                                    <input type="text" class="form-control mb-3" id="profession"
                                                        placeholder="username" name="username"
                                                        value="{{ @$data->username }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="address">Address</label>
                                                    <input type="text" class="form-control mb-3" id="address"
                                                        placeholder="Address" name="address"
                                                        value="{{ @$data->address }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="location">Location</label>
                                                    <input type="text" class="form-control mb-3" name="location"
                                                        id="location" placeholder="Location"
                                                        value="{{ @$data->location }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="phone">Phone</label>
                                                    <input type="text" class="form-control mb-3" id="phone"
                                                        placeholder="Write your phone number here" name="phone"
                                                        value="{{ @$data->phone }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" class="form-control mb-3" id="email"
                                                        placeholder="Write your email here" name="email"
                                                        value="{{ @$data->email }}">
                                                </div>
                                            </div>

                                           

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Password</label>
                                                    <input type="password" class="form-control mb-3"
                                                        placeholder="Enter your password" name="password">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Confirm Password</label>
                                                    <input type="password" class="form-control mb-3"
                                                        placeholder="Enter your password" name="password_confirmation">
                                                </div>
                                            </div>

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

<!--  BEGIN CUSTOM SCRIPTS FILE  -->


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