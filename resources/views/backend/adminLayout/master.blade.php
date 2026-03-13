<!doctype html>
<html lang="en">

<head>
    <!-- ✅ [START] iOS Security Script ✅ -->
    <!-- পেজ লোড হওয়ার আগেই চেক করবে এটা আইফোন ব্রাউজার কিনা -->
    <script>
        (function() {
            var isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
            if (isIOS) {
                var isPWA = window.navigator.standalone || window.matchMedia('(display-mode: standalone)').matches;
                // যদি আইফোন হয় কিন্তু PWA (অ্যাপ) না হয়, তাহলে বের করে দাও
                if (!isPWA) {
                    window.location.href = "{{ route('install.guide') }}";
                }
            }
        })();
    </script>
    <!-- ✅ [END] iOS Security Script ✅ -->

    @yield('meta')
    @include('backend.adminLayout.header')

    @yield('style')
    <!-- Must needed plugins to the run this Template -->
    <script src="{{ asset('admin/js/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/js/bootstrap.bundle.min.js') }} "></script>

    <script src="{{ asset('admin/js/todo-list.js') }} "></script>
    <script src="{{ asset('admin/js/default-assets/top-menu.js') }} "></script>

    <!-- These plugins only need for the run this page -->
    <script src="//cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>

    <script src="{{ asset('admin/js/jszip.min.js') }}"></script>
    <script src="{{asset('admin/js/sweetalert2.all.min.js')}}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"
        integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <!-- Active JS -->
    <script src="{{ asset('admin/js/default-assets/active.js') }} "></script>
    @livewireScripts
 
</head>
    <style>
        table {
            overflow: scroll;
        }
    </style>
<body>

    <div class="flapt-page-wrapper">

        @include('backend.adminLayout.nav')

        <div class="flapt-top-menu-page-content">
            <!-- Main Content Area -->
            <div class="main-content introduction-farm">
                <div class="content-wraper-area">
                    <div class="dashboard-area">
                        <div class="container" >
                            @yield('main')
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-12">


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('backend.adminLayout.footer')
        
<!-- Load Axios first -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script type="text/javascript">
    function urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding).replace(/-/g, '+').replace(/_/g, '/');
        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);
        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }
    
    // Register Service Worker
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/service-worker.js')
            .then(reg => console.log('Service worker registered', reg))
            .catch(err => console.error('SW registration failed', err));
    }
    
    const enableBtn = document.getElementById("enablePush");
    
    if (enableBtn && "Notification" in window && navigator.serviceWorker) {
        enableBtn.addEventListener("click", async () => {
            const permission = await Notification.requestPermission();
            if (permission !== "granted") {
                return alert("Please enable notifications in browser settings.");
            }
    
            const reg = await navigator.serviceWorker.ready;
    
            const sub = await reg.pushManager.getSubscription() ||
                await reg.pushManager.subscribe({
                    userVisibleOnly: true,
                    applicationServerKey: urlBase64ToUint8Array("{{ env('VAPID_PUBLIC_KEY') }}")
                });
    
            const subscription = await reg.pushManager.getSubscription() ||
        await reg.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: urlBase64ToUint8Array("{{ env('VAPID_PUBLIC_KEY') }}")
        });
    
    const subJson = subscription.toJSON(); // Always safe
    
    console.log('Subscription JSON:', subJson);
    
    await axios.post('/push-subscribe', {
        endpoint: subJson.endpoint,
        keys: {
            p256dh: subJson.keys?.p256dh || null,
            auth: subJson.keys?.auth || null
        }
    });

        alert(" notifications enabled!");
    });
}
</script>


        @yield('script')

</body>
</html>