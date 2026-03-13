@extends('frontend.layout.master')


@section('main')
    <div class="service-area pt_80 pb_80" id="services">
        <div class="container wow fadeIn">

            <div class="row">

                <div class="col-md-12">
                    <div class="form-group">

                        <h4 class="text-center"> <u>Order Status</u> </h4>
                    </div>
                </div>
                <div>

                    <h1 class="text-center">Order Number - {{ @$data->invoice_no }}</h1>
                </div>
                <div class="table-responsive text-nowrap mb-4">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Item</th>
                                <th>Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(@$data)
                            @foreach($data->items as $item)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>
                                    <div>
                                        {{ @$item->link}} <br>
                                        Quantity : {{ @$item->qty}} , Color : {{ @$item->color}} , Shade : {{ @$item->shade}} , Size : {{ @$item->size}}  ,  Other : {{ @$item->other}} ,  Coupon : {{ @$item->coupon}}
                                         
                                       
                                     
                                    </div>
                                </td>
                                <td> {{ $item->qty }}</td>
                               
                                
                               
                            </tr>
                        @endforeach
                            @endif
                            
                        </tbody>
                    </table>
                </div>

                <div>
                    <h3 class="text-center">Total Paid Amount - {{ @$data->paid }}</h3>
                </div>

                <div>

                    <h1>Order Status - {{ @$data->status() }}</h1>
                </div>
    

            </div>
        </div>
    </div>




@endsection
