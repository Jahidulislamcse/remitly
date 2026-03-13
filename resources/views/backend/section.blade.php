
@extends('backend.layout.master')
@section('meta')

<title>{{ isset($title)?$title:'welcome' }} - {{ env('APP_NAME') }}</title>

<link rel="canonical" href="{{ route('user.index') }}" />
<meta name="description" content="&lt;p&gt;Discover the power of residential proxies and RDP services at IPMela.com. Unmatched reliability and performance for your online needs.&lt;/p&gt;" />
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="article" />
<meta property="og:title" content="Worldsocks5 LTD" />
<meta property="og:description" content="&lt;p&gt;Discover the power of residential proxies and RDP services at IPMela.com. Unmatched reliability and performance for your online needs.&lt;/p&gt;" />
<meta property="og:url" content="{{ route('user.index') }}" />
<meta property="og:site_name" content="Worldsocks5 LTD" />
<meta property="article:publisher" content="#" />
<meta property="og:image" content="admin/uploads/settings/1717613677.png" />


@endsection
@section('style')




@endsection
@section('main')

<div class="container">
    <div class="row g-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body card-breadcrumb">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Section</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a>
                                </li>
                                <li class="breadcrumb-item active">Section</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="nav flex-column nav-pills me-3 account-tab" id="v-pills-tab"
                        role="tablist" aria-orientation="vertical">
                        <button class="nav-link active" id="v-pills-slider-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-slider" type="button" role="tab"
                            aria-controls="v-pills-slider" aria-selected="true">Home</button>
                        <button class="nav-link" id="v-pills-whyus-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-whyus" type="button" role="tab"
                            aria-controls="v-pills-whyus"
                            aria-selected="false">Why us</button>
                        <button class="nav-link" id="v-pills-aboutus-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-aboutus" type="button" role="tab"
                            aria-controls="v-pills-aboutus" aria-selected="false">About us</button>
                        <button class="nav-link" id="v-pills-review-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-review" type="button" role="tab"
                            aria-controls="v-pills-review" aria-selected="false">Reviews</button>
                        <button class="nav-link" id="v-pills-footer-tab" data-bs-toggle="pill"
                            data-bs-target="#v-pills-footer" type="button" role="tab"
                            aria-controls="v-pills-footer" aria-selected="false">Footer</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <form action="{{ route('admin.section.store')}}" method="post" enctype="multipart/form-data">
                @csrf
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-slider" role="tabpanel"
                    aria-labelledby="v-pills-slider-tab" tabindex="0">
                    <div class="card mb-4">
                        <div class="card-header-cu">
                            <h6 class="mb-0">Slider</h6>
                        </div>
                        <div class="card-body">
                           
                                <div class="d-flex align-items-center border-bottom pb-4 mb-4">
                                    <div class="account-img">
                                        <img src="{{ asset(section('slider_image')) }}" alt="">
                                    </div>
                                    <div>
                                        <span class="fs-sm text-muted">
                                            ( Upload a PNG or JPG, size limit is 15 MB. )
                                        </span>
                                        <div class="mt-3">
                                            <input type="file" name="slider_image" class="btn btn-sm btn-primary"></input>
                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center border-bottom pb-4 mb-4">
                                    <div class="account-img">
                                        <img src="{{ asset(section('slider_image2')) }}" alt="">
                                    </div>
                                    <div>
                                        <span class="fs-sm text-muted">
                                            ( Upload a PNG or JPG, size limit is 15 MB. )
                                        </span>
                                        <div class="mt-3">
                                            <input type="file" name="file[][slider_image2]" class="btn btn-sm btn-primary"></input>
                                            
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Heading</label>
                                            <input type="text" class="form-control" name="key[][heading]" value="{{ section('heading') }}" >
                                           
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Sub Heading</label>
                                            <input type="text" class="form-control" name="key[][sub_heading]" value="{{ section('sub_heading') }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Button Text</label>
                                            <input type="text" class="form-control" name="key[][heading_button]" value="{{ section('heading_button') }}" >
                                        </div>
                                    </div>
                                                       
                                    
                                </div>
                            
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header-cu">
                            <h6 class="mb-0">Slider Card</h6>
                        </div>
                        <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Customer Satisfaction</label>
                                            <input type="text" class="form-control" name="key[][customer_satisfaction]" value="{{ section('customer_satisfaction') }}" >
                                           
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">customers</label>
                                            <input type="text" class="form-control" name="key[][customers]" value="{{ section('customers') }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Years of service</label>
                                            <input type="text" class="form-control" name="key[][year_of_service]" value="{{ section('year_of_service') }}" >
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="v-pills-whyus" role="tabpanel"
                    aria-labelledby="v-pills-whyus-tab" tabindex="0">
                    
                    <div class="card mb-4">
                        <div class="card-header-cu">
                            <h6 class="mb-0">Why Choose US</h6>
                        </div>
                        <div class="card-body">
                           
                             
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Heading</label>
                                            <input type="text" class="form-control" name="key[][whyus_heading]" value="{{ section('whyus_heading') }}" >
                                           
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <input type="text" class="form-control" name="key[][whyus_description]" value="{{ section('whyus_description') }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Item 1</label>
                                            <input type="text" placeholder="Title" class="form-control" name="key[][whyus_item_1_title]" value="{{ section('whyus_item_1_title') }}" >
                                            <input type="text" placeholder="Desctiprion" class="form-control" name="key[][whyus_item_1_descritpion]" value="{{ section('whyus_item_1_descritpion') }}" >
                                       
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Item 2</label>
                                            <input type="text" placeholder="Title" class="form-control" name="key[][whyus_item_2_title]" value="{{ section('whyus_item_2_title') }}" >
                                            <input type="text" placeholder="Desctiprion" class="form-control" name="key[][whyus_item_2_descritpion]" value="{{ section('whyus_item_2_descritpion') }}" >
                                        
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Item 3</label>
                                            <input type="text" placeholder="Title" class="form-control" name="key[][whyus_item_3_title]" value="{{ section('whyus_item_3_title') }}" >
                                            <input type="text" placeholder="Desctiprion" class="form-control" name="key[][whyus_item_3_descritpion]" value="{{ section('whyus_item_3_descritpion') }}" >
                                       
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Item 4</label>
                                            <input type="text" placeholder="Title" class="form-control" name="key[][whyus_item_4_title]" value="{{ section('whyus_item_4_title') }}" >
                                            <input type="text" placeholder="Desctiprion" class="form-control" name="key[][whyus_item_4_descritpion]" value="{{ section('whyus_item_4_descritpion') }}" >
                                        
                                    </div>
                                                       
                                    
                                </div>
                            
                        </div>
                    </div>

                </div>

                <div class="tab-pane fade" id="v-pills-aboutus" role="tabpanel"
                    aria-labelledby="v-pills-aboutus-tab" tabindex="0">

                    <div class="card mb-4">
                        <div class="card-header-cu">
                            <h6 class="mb-0">About US</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center border-bottom pb-4 mb-4">
                                <div class="account-img">
                                    <img src="{{ asset(section('aboutus_image')) }}" alt="">
                                </div>
                                <div>
                                    <span class="fs-sm text-muted">
                                        ( Upload a PNG or JPG, size limit is 15 MB. )
                                    </span>
                                    <div class="mt-3">
                                        <input type="file" name="aboutus_image" class="btn btn-sm btn-primary"></input>
                                       
                                    </div>
                                </div>
                            </div>
                             
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Heading</label>
                                            <input type="text" class="form-control" name="key[][aboutus_heading]" value="{{ section('aboutus_heading') }}" >
                                           
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <input type="text" class="form-control" name="key[][aboutus_description]" value="{{ section('aboutus_description') }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Item 1</label>
                                            <input type="text" placeholder="Title" class="form-control" name="key[][aboutus_item_1_title]" value="{{ section('aboutus_item_1_title') }}" >
                                            <input type="text" placeholder="Desctiprion" class="form-control" name="key[][aboutus_item_1_descritpion]" value="{{ section('aboutus_item_1_descritpion') }}" >
                                       
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Item 2</label>
                                            <input type="text" placeholder="Title" class="form-control" name="key[][aboutus_item_2_title]" value="{{ section('aboutus_item_2_title') }}" >
                                            <input type="text" placeholder="Desctiprion" class="form-control" name="key[][aboutus_item_2_descritpion]" value="{{ section('aboutus_item_2_descritpion') }}" >
                                        
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Item 3</label>
                                            <input type="text" placeholder="Title" class="form-control" name="key[][aboutus_item_3_title]" value="{{ section('aboutus_item_3_title') }}" >
                                            <input type="text" placeholder="Desctiprion" class="form-control" name="key[][aboutus_item_3_descritpion]" value="{{ section('aboutus_item_3_descritpion') }}" >
                                       
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Item 4</label>
                                            <input type="text" placeholder="Title" class="form-control" name="key[][aboutus_item_4_title]" value="{{ section('aboutus_item_4_title') }}" >
                                            <input type="text" placeholder="Desctiprion" class="form-control" name="key[][aboutus_item_4_descritpion]" value="{{ section('aboutus_item_4_descritpion') }}" >
                                        
                                    </div>
                                                       
                                    
                                </div>
                            
                        </div>
                    </div>


                </div>

                <div class="tab-pane fade" id="v-pills-review" role="tabpanel"
                aria-labelledby="v-pills-review-tab" tabindex="0">
                
                <div class="card mb-4">
                    <div class="card-header-cu">
                        <h6 class="mb-0">Review Section</h6>
                    </div>
                    <div class="card-body">
                                              
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Heading</label>
                                        <input type="text" class="form-control" name="key[][review_heading]" value="{{ section('review_heading') }}" >
                                       
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <input type="text" class="form-control" name="key[][review_description]" value="{{ section('review_description') }}" >
                                    </div>
                                </div>
                             
                            </div>
                    </div>
                </div>

            </div>

                <div class="tab-pane fade" id="v-pills-footer" role="tabpanel"
                    aria-labelledby="v-pills-footer-tab" tabindex="0">
                    
                    <div class="card mb-4">
                        <div class="card-header-cu">
                            <h6 class="mb-0">Footer US</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center border-bottom pb-4 mb-4">
                                <div class="account-img">
                                    <img src="{{ asset(section('footer_image')) }}" alt="">
                                </div>
                                <div>
                                    <span class="fs-sm text-muted">
                                        ( Upload a PNG or JPG, size limit is 15 MB. )
                                    </span>
                                    <div class="mt-3">
                                        <input type="file" name="footer_image" class="btn btn-sm btn-primary"></input>
                                       
                                    </div>
                                </div>
                            </div>
                             
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Heading</label>
                                            <input type="text" class="form-control" name="key[][footer_heading]" value="{{ section('footer_heading') }}" >
                                           
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <input type="text" class="form-control" name="key[][footer_description]" value="{{ section('footer_description') }}" >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Social 1</label>
                                            <input type="text" placeholder="Title" class="form-control" name="key[][social_item_1_title]" value="{{ section('social_item_1_title') }}" >
                                            <input type="text" placeholder="link" class="form-control" name="key[][social_item_1_descritpion]" value="{{ section('social_item_1_descritpion') }}" >
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Social 2</label>
                                            <input type="text" placeholder="Title" class="form-control" name="key[][social_item_2_title]" value="{{ section('social_item_2_title') }}" >
                                            <input type="text" placeholder="link" class="form-control" name="key[][social_item_2_descritpion]" value="{{ section('social_item_2_descritpion') }}" >
                                        
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Social 3</label>
                                            <input type="text" placeholder="Title" class="form-control" name="key[][social_item_3_title]" value="{{ section('social_item_3_title') }}" >
                                            <input type="text" placeholder="link" class="form-control" name="key[][social_item_3_descritpion]" value="{{ section('social_item_3_descritpion') }}" >
                                    </div>
                                    <div class="col-md-3">
                                        <label for="">Social 4</label>
                                            <input type="text" placeholder="Title" class="form-control" name="key[][social_item_4_title]" value="{{ section('social_item_4_title') }}" >
                                            <input type="text" placeholder="link" class="form-control" name="key[][social_item_4_descritpion]" value="{{ section('social_item_4_descritpion') }}" >
                                    </div>
                                </div>
                        </div>
                    </div>

                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        </div>
    </div>
</div>


@endsection
@section('script')


<!-- These plugins only need for the run this page -->
<script src="{{ asset('admin/js/apexcharts.min.js') }} "></script>
<script src="{{ asset('admin/js/dashboard-custom.js') }} "></script>


@endsection