<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Title -->
    <title>{{ siteInfo()->company_name }}- Login </title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset( siteInfo()->icon ) }}">
    <!-- Plugins File -->
    <link rel="stylesheet" href="{{ asset('admin') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('admin') }}/css/classynav.css">
    <link rel="stylesheet" href="{{ asset('admin') }}/css/animate.css">

    <!-- Master Stylesheet [If you remove this CSS file, your file will be broken undoubtedly.] -->
    <link rel="stylesheet" href="{{ asset('admin') }}/style.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>

<body class="login-area">


    <!-- ======================================
    ******* Page Wrapper Area Start **********
    ======================================= -->

    <div class="main-content- h-100vh">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center">
                <div class="col-sm-10 col-md-7 col-lg-5">
                    <!-- Middle Box -->
                    <div class="middle-box">


                        <div class="log-header-area card p-4 mb-4 text-center">
                            @if (session('status'))
                                <div class="mb-4 font-medium text-sm text-green-600">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <h5 class="mb-0">OTP Varify</h5>
                            <span>We have sent you 5 digit otp code . <a href="{{  route('send.otp') }}">resend</a></span>
                        </div>

                        <div class="card">
                            <div class="card-body p-4">
                                <form action="{{ route('otp.varify') }}" method="POST">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label class="text-muted" for="emailaddress"> OTP CODE </label>
                                        <input class="form-control" type="text" name="otp" id="emailaddress" required
                                            placeholder="Enter your 5 Digit OTP Code">
                                            @error('otp')
                                            <span class="text-danger">{{ $message }}</span>                                                
                                            @enderror
                                    </div>
                                    <input type="hidden" name="phone" value="{{ $phone }}">
                                    <div class="form-group mb-3">
                                        <button class="btn btn-primary w-100 btn-lg" type="submit">Submit</button>
                                    </div>

                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ======================================
    ********* Page Wrapper Area End ***********
    ======================================= -->

    <!-- Must needed plugins to the run this Template -->
    <script src="{{ asset('admin') }}/js/jquery.min.js"></script>
    <script src="{{ asset('admin') }}/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('admin') }}/js/default-assets/setting.js"></script>
    <script src="{{ asset('admin') }}/js/default-assets/scrool-bar.js"></script>
    <script src="{{ asset('admin') }}/js/todo-list.js"></script>
    <script src="{{ asset('admin') }}/js/default-assets/top-menu.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"
        integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Active JS -->
    <script src="{{ asset('admin') }}/js/default-assets/active.js"></script>

    <script>
        @if(session()->get('response') === false)
            toastr.error('{{ session()->get('msg') }}')
            @endif
            @if(session()->get('response') === true)
            toastr.success('{{ session()->get('msg') }}')
            @endif
    
            @if ($errors->any())
            @foreach ($errors->all() as $error)
       toastr.error('{{ $error }}')
                             
       @endforeach
    
       @endif
   
    </script>

</body>

</html>