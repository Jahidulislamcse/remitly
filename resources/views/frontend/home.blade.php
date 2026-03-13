@extends('frontend.layout.master')


@section('main')
<!-- start section -->



<!--<div class="slider">-->
<!--    <div class="slide-carousel owl-carousel">-->

<!--        <div class="slider-item" style="background-image:url({{ asset(section('slider_image')) }});">-->
<!--            <div class="slider-bg"></div>-->
<!--            <div class="container">-->
<!--                <div class="row">-->
<!--                    <div class="col-md-7 col-sm-12 ">-->
<!--                        <div class="slider-table">-->
<!--                            <div class="slider-text">-->

<!--                                <div class="text-animated">-->
<!--                                    <h1>{{ section('heading') }}</h1>-->
<!--                                </div>-->

<!--                                <div class="text-animated">-->
<!--                                    <p>-->
<!--                                    </p>-->
<!--                                    <p>{{ section('sub_heading') }}</p>-->
<!--                                    <p></p>-->
<!--                                </div>-->

<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
        
<!--        <div class="slider-item" style="background-image:url({{ asset(section('slider_image2')) }});">-->
<!--            <div class="slider-bg"></div>-->
<!--            <div class="container">-->
<!--                <div class="row">-->
<!--                    <div class="col-md-7 col-sm-12 ">-->
<!--                        <div class="slider-table">-->
<!--                            <div class="slider-text">-->

<!--                                <div class="text-animated">-->
<!--                                    <h1>{{ section('heading') }}</h1>-->
<!--                                </div>-->

<!--                                <div class="text-animated">-->
<!--                                    <p>-->
<!--                                    </p>-->
<!--                                    <p>{{ section('sub_heading') }}</p>-->
<!--                                    <p></p>-->
<!--                                </div>-->

<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->

<!--    </div>-->
<!--</div>-->




<div class="service-area pt_80 pb_80" >
    <div class="container wow fadeIn">
        <div class="row">
            <div class="col-md-12">
                
                        <h1 class="text-center">Announcement</h1>
                        
                  
                @foreach (App\Models\Announc::all() as  $announce )
                          {!! $announce->content !!}
                        @endforeach
            </div>
        </div>
        <div class="row" style="    margin: 20px;">

        <div class="row justify-content-center">
          
            <div class="col-md-3 col-6 text-center">
                <label class="radio-container">
                  <a target="_blank" href="https://www.amazon.com/">
                        <img src="{{ asset('fileManager/Amazon-Logo.png') }}"   >
                  </a>
                </label>
               
            </div>
            <div class="col-md-3 col-6 text-center">
                <label class="radio-container">
                   <a target="_blank" href="https://www.ebay.com/">
                    <img src="{{ asset('fileManager/ebay.png') }}"  >
                    </a>
                </label>
               
            </div>
            <div class="col-md-3 col-6 text-center">
                <label class="radio-container">
                    <a target="_blank" href="https://www.walmart.com/">
                    <img src="{{ asset('fileManager/Walmart_logo.svg.png') }}">
                     </a>
                </label>
                

            </div>

            <div class="col-md-3 col-6 text-center">
                <label class="radio-container">
                     <a target="_blank" href="https://www.bestbuy.com/">
                    <img src="{{ asset('fileManager/Best_Buy.svg') }}"  >
                     </a>
                </label>
               

            </div>
            
              <div class="col-md-3 col-6 text-center">
                <label class="radio-container">
                     <a target="_blank" href="https://www.jomashop.com/">
                    <img src="{{ asset('fileManager/jomashop.png') }}" >
                     </a>
                </label>
                

            </div>
            
              <div class="col-md-3 col-6 text-center">
                <label class="radio-container">
                     <a target="_blank" href="https://www.fossil.com/en-us/">
                    <img src="{{ asset('fileManager/fossil.svg') }}"   >
                     </a>
                </label>
              

            </div>
            
             <div class="col-md-3 col-6 text-center ">
                <label class="radio-container">
                     <a target="_blank" href="https://www.maccosmetics.com/">
                    <img src="{{ asset('fileManager/MAC-Cosmetics-Logo.png') }}"    >
                     </a>
                </label>
            </div>
            
              <div class="col-md-3 col-6 text-center ">
                <label class="radio-container">
                     <a target="_blank" href="https://www.alibaba.com/">
                    <img src="{{ asset('fileManager/alibaba.png') }}"    >
                     </a>
                </label>
            </div>
            
              <div class="col-md-3 col-6 text-center ">
                <label class="radio-container">
                     <a target="_blank" href="https://www.aliexpress.com/">
                    <img src="{{ asset('fileManager/aliexpress.png') }}"    >
                     </a>
                </label>
            </div>
            
              <div class="col-md-3 col-6 text-center ">
                <label class="radio-container">
                     <a target="_blank" href="https://www.adidas.com/us">
                    <img src="{{ asset('fileManager/adidas.png') }}"    >
                     </a>
                </label>
            </div>
            
              <div class="col-md-3 col-6 text-center ">
                <label class="radio-container">
                     <a target="_blank" href="https://www.flipkart.com/">
                    <img src="{{ asset('fileManager/flipkart.jpg') }}"    >
                     </a>
                </label>
            </div>
            
              <div class="col-md-3 col-6 text-center ">
                <label class="radio-container">
                     <a target="_blank" href="https://www.indiamart.com/">
                    <img src="{{ asset('fileManager/indiamart.png') }}"    >
                     </a>
                </label>
            </div>
            
              <div class="col-md-3 col-6 text-center ">
                <label class="radio-container">
                     <a target="_blank" href="https://www.myntra.com/">
                    <img src="{{ asset('fileManager/myntra.png') }}"    >
                     </a>
                </label>
            </div>
            
              <div class="col-md-3 col-6 text-center ">
                <label class="radio-container">
                     <a target="_blank" href="https://www.sephora.com/">
                    <img src="{{ asset('fileManager/sephora_Logo.webp') }}"    >
                     </a>
                </label>
            </div>
            
              <div class="col-md-3 col-6 text-center ">
                <label class="radio-container">
                     <a target="_blank" href="https://www.ulta.com/">
                    <img src="{{ asset('fileManager/ultabeauty.png') }}"    >
                     </a>
                </label>
            </div>
            
     
           
        </div>


        </div>
    </div>
</div>




@endsection