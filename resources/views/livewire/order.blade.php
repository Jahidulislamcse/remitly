<div>

    <div style="position: relative">
        <div class="row">
            @foreach ($links as $index => $link)
            <div class="col-md-6">
                <div class="form-group">


                    <div class="row">
                        <div class="col-md-8 col-8" style=" padding: 0px; ">
                            <label for="link">Enter Product Link</label>
                            <input type="text" wire:model="links.{{ $index }}.link" class="form-control">
                        </div>
                        <div class="col-md-4 col-4" style=" padding: 0px; ">
                            <label for="link">Quantity</label>
                            <input wire:change="price_convert({{ $index }})" type="number" wire:model="links.{{ $index }}.quantity" class="form-control">
                        </div>
                        <div class="col-md-2 col-4" style=" padding: 0px; ">
                            <input type="text" wire:model="links.{{ $index }}.size" placeholder="Size:"
                                style="width: 100%; padding:5px">
                        </div>
                        <div class="col-md-2 col-4" style=" padding: 0px; ">
                            <input type="text" wire:model="links.{{ $index }}.color" placeholder="Color:"
                                style="width: 100%; padding:5px">
                        </div>
                        <div class="col-md-2 col-4" style=" padding: 0px; ">
                            <input type="text" wire:model="links.{{ $index }}.Shade" placeholder="Shade:"
                                style="width: 100%; padding:5px">
                        </div>
                        <div class="col-md-2 col-4" style=" padding: 0px; ">
                            <input type="text" wire:model="links.{{ $index }}.other" placeholder="Other:"
                                style="width: 100%; padding:5px">
                        </div>
                        <div class="col-md-2 col-4" style=" padding: 0px; ">
                            <input type="text" wire:model="links.{{ $index }}.coupon"
                                placeholder="Coupon:" style="width: 100%; padding:5px">
                        </div>
                        <div class="col-md-2 col-4" style=" padding: 0px; ">
                            <input type="text" wire:model="links.{{ $index }}.comment"
                                placeholder="comment:" style="width: 100%; padding:5px">
                        </div>

                    </div>

                </div>
            </div>
            <div class="col-md-3" style="padding: 0px; ">
                <div class="form-group">
                    <label for="price">Enter Price</label>
                    <div class="input-group  ">
                        <div class="input-group-prepend ">
                            <span class="input-group-text" id="basic-addon1">$</span>
                        </div>
                        <input type="number" wire:model.live="links.{{ $index }}.price"
                            wire:change="price_convert({{ $index }})" class="form-control">
                    </div>

                    <div class="input-group mb-3 ">
                        <div class="input-group-prepend ">
                            <span class="input-group-text" id="basic-addon1"> US Shipping: $</span>
                        </div>
                        <input type="number" wire:model.live="links.{{ $index }}.shipping"
                            wire:change="price_convert({{ $index }})" placeholder=""
                            class="form-control">
                    </div>

                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="bdt">BDT</label>
                    <h1>৳ {{ $link['bdt'] ?? 0 }}</h1>

                </div>
            </div>
            @if ($loop->iteration != 1)
            <div class="col-md-12 mt-2">
                <button type="button" wire:click="removeLink({{ $index }})"
                    class="btn btn-danger">Remove Link</button>
            </div>
            @endif
            @endforeach

            <table class="table fs-24px" style=" font-size: 24px; ">
                <tbody>
                    <tr>
                        <td style=" text-align: right; ">Sub Total BDT:</td>
                        <td>{{ $subtotal }}</td>
                    </tr>
                    <tr>
                        <td style=" text-align: right; ">New York Sales Tax 8.8% BDT:</td>
                        <td>{{ $tax }}</td>
                    </tr>
                    <tr>
                        <td style=" text-align: right; ">Total BDT:</td>
                        <td>{{ $total }}</td>
                    </tr>
                </tbody>

            </table>
        </div>



        <button type="button" wire:click="addLink" class="btn btn-primary mt-3">Add More Link</button>

        <div class="row justify-content-center">

            <span
                style="
    border: 1px solid;
    font-size: 24px;
    text-align: center;
    margin: 20px;
        padding: 20px;
">

                * To Confirm order you need to Pay 80% Advance <br>
                * Rest 20% weight charge when product is in Bangladesh

            </span>



            <button class="btn btn-success mt-5" wire:click="place_order()">Confirm</button>

        </div>
        @if (!auth()->check())
        <div
            style="background: #00000042;width:100%;height:100%;position: absolute;top: 0;backdrop-filter: blur(2px);">
            <div style="margin: 200px auto;text-align: center;">
                <h4 style="color: #ffe690;font-size: 30px;">Please Sign in to place order</h4>
                <a href="{{ route('user.login') }}" class="btn btn-success"> Login</a>
                <a href="{{ route('register') }}" class="btn btn-info"> Register</a>
            </div>

        </div>
        @endif



    </div>

</div>