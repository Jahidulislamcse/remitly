@extends('frontend.layout.master')


@section('main')
    <section class="mt-5">
        <div class="bg-light py-5">
            <div class="container">
                <div class="d-flex justify-content-between">
                    <h1 class="fw-bold">Contact us</h1>
                    <nav class="pt-3"
                        style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                        aria-label="breadcrumb">
                        
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <main>
        <div class="container py-5">
            <div class="row g-5">
                <!-- Contact Information Block -->
                <div class="col-xl-12">
                    <div class="row row-cols-md-2 g-4">
                        <div class="aos-item" data-aos="fade-up" data-aos-delay="200">
                            <div class="aos-item__inner">
                                <div class="bg-light hvr-shutter-out-horizontal d-block p-3">
                                    <div class="d-flex justify-content-start">
                                        <i class="far fa-envelope h3 pe-2"></i>
                                        <span class="h5">Email</span>
                                    </div>
                                    <span>{{ @siteInfo()->email }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="aos-item" data-aos="fade-up" data-aos-delay="400">
                            <div class="aos-item__inner">
                                <div class="bg-light hvr-shutter-out-horizontal d-block p-3">
                                    <div class="d-flex justify-content-start">
                                        <i class="fas fa-phone h3 pe-2"></i>
                                        <span class="h5">Phone</span>
                                    </div>
                                    <span>{{ @siteInfo()->phone }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="aos-item mt-4" data-aos="fade-up" data-aos-delay="600">
                        <div class="aos-item__inner">
                            <div class="bg-light hvr-shutter-out-horizontal d-block p-3">
                                <div class="d-flex justify-content-start">
                                    <i class="fa-solid fa-location-pin h3 pe-2"></i>
                                    <span class="h5">Office location</span>
                                </div>
                                <span>{{ @siteInfo()->hq_address }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="aos-item" data-aos="fade-up" data-aos-delay="800">
                        <div class="mt-4 w-100 aos-item__inner">
                            <iframe class="hvr-shadow" width="100%" height="345" frameborder="0" scrolling="no"
                                marginheight="0" marginwidth="0"
                                src="https://maps.google.com/maps?width=100%25&amp;height=300&amp;hl=en&amp;q={{ @siteInfo()->hq_address }}&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"><a
                                    href="https://www.maps.ie/distance-area-calculator.html">measure acres/hectares on
                                    map</a></iframe>
                        </div>
                    </div>
                </div>
    </main>
@endsection
