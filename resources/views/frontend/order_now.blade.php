@extends('frontend.layout.master')


@section('main')



<div class="service-area pt_80 pb_80" id="services">
    <div class="container wow fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="main-headline">
                    <div class="headline">
                        <h2>Order Now</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">

                    @livewire('order', ['id' => @$id])


        </div>
    </div>
</div>




@endsection