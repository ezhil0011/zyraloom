@extends('frontend.layouts.master')

@section('title','Checkout page')

@section('main-content')

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{ route('home') }}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0)">Checkout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Start Checkout -->
    <section class="shop checkout section">
        <div class="container">
            <form class="form" method="POST" action="{{ route('cart.order') }}">
                @csrf
                <div class="row">

                    <div class="col-lg-8 col-12">
                        <div class="checkout-form">
                            <h2>Make Your Checkout Here</h2>
                            <p>Please register in order to checkout more quickly</p>
                            <!-- Form -->
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>First Name<span>*</span></label>
                                        <input type="text" name="first_name" placeholder="" value="{{ old('first_name') }}">
                                        @error('first_name')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Last Name<span>*</span></label>
                                        <input type="text" name="last_name" placeholder="" value="{{ old('last_name') }}">
                                        @error('last_name')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Email Address<span>*</span></label>
                                        <input type="email" name="email" placeholder="" value="{{ old('email') }}">
                                        @error('email')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Phone Number <span>*</span></label>
                                        <input type="number" name="phone" placeholder="" required value="{{ old('phone') }}">
                                        @error('phone')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Country<span>*</span></label>
                                        <select name="country" id="country" class="form-control">
                                            <option value="IND">India</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Address Line 1<span>*</span></label>
                                        <input type="text" name="address1" placeholder="" value="{{ old('address1') }}">
                                        @error('address1')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Address Line 2</label>
                                        <input type="text" name="address2" placeholder="" value="{{ old('address2') }}">
                                        @error('address2')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Postal Code</label>
                                        <input type="text" name="post_code" placeholder="" value="{{ old('post_code') }}">
                                        @error('post_code')
                                            <span class='text-danger'>{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <!--/ End Form -->
                        </div>
                    </div>

                    <div class="col-lg-4 col-12">
                        <div class="order-details">
                            <!-- Order Widget -->
                            <div class="single-widget">
                                <h2>CART  TOTALS</h2>
                                <div class="content">
                                    <ul>
                                        <li class="order_subtotal" data-price="{{ Helper::totalCartPrice() }}">Cart Subtotal<span>₹{{ number_format(Helper::totalCartPrice(),2) }}</span></li>
                                        <li class="shipping">
                                            <div style="width:100%">
                                                <strong>Select Shipping / Address</strong>
                                            </div>

                                            @if(count(Helper::shipping())>0 && Helper::cartCount()>0)
                                                <select name="shipping" id="shippingSelect" class="nice-select form-select">
                                                    <option value="">Select your address</option>

                                                    @foreach(Helper::shipping() as $shipping)
                                                        @php
                                                            // Build readable preview; adapt these fields to your Shipping model
                                                            $parts = [
                                                                $shipping->label ?? null,
                                                                $shipping->house_no ?? $shipping->house ?? null,
                                                                $shipping->street ?? null,
                                                                $shipping->area ?? null,
                                                                $shipping->city ?? null,
                                                                $shipping->state ?? null,
                                                                $shipping->pincode ?? null,
                                                            ];
                                                            $addressPreview = trim(implode(', ', array_filter($parts)));
                                                            $displayText = $addressPreview ?: ($shipping->type . ' - ₹' . number_format($shipping->price, 2));
                                                        @endphp

                                                        <option value="{{ $shipping->id }}"
                                                                data-price="{{ $shipping->price }}">
                                                            {{ $displayText }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <span>Free</span>
                                            @endif
                                        </li>

                                        <!-- optional separate shipping display -->
                                        <li style="display:flex; justify-content:space-between; align-items:center;">
                                            <span>Shipping:</span>
                                            <span id="shippingAmount">₹0.00</span>
                                        </li>

                                        @if(session('coupon'))
                                            <li class="coupon_price" data-price="{{ session('coupon')['value'] }}">You Save<span>₹{{ number_format(session('coupon')['value'],2) }}</span></li>
                                        @endif

                                        @php
                                            $total_amount = Helper::totalCartPrice();
                                            if(session('coupon')){
                                                $total_amount = $total_amount - session('coupon')['value'];
                                            }
                                        @endphp

                                        <li class="last" id="order_total_price">Total<span>₹{{ number_format($total_amount,2) }}</span></li>
                                    </ul>
                                </div>
                            </div>
                            <!--/ End Order Widget -->

                            <!-- Order Widget -->
                            <div class="single-widget">
                                <h2>Payments</h2>
                                <div class="content">
                                    <div class="checkbox">
                                        <div class="form-group">
                                            <input name="payment_method" type="radio" id="cod" value="cod" checked> <label for="cod"> Cash On Delivery</label><br>
                                            <input name="payment_method" type="radio" id="paypal" value="paypal"> <label for="paypal"> PayPal</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ End Order Widget -->

                            <!-- Payment Method Widget -->
                            <div class="single-widget payement">
                                <div class="content">
                                    <img src="{{ asset('backend/img/payment-method.png') }}" alt="#">
                                </div>
                            </div>
                            <!--/ End Payment Method Widget -->

                            <!-- Button Widget -->
                            <div class="single-widget get-button">
                                <div class="content">
                                    <div class="button">
                                        <button type="submit" class="btn">proceed to checkout</button>
                                    </div>
                                </div>
                            </div>
                            <!--/ End Button Widget -->
                        </div>
                    </div>

                </div>
            </form>

            <!-- Hidden cart total element for JS (numeric only) -->
            <div id="cartTotal" data-amount="{{ Helper::totalCartPrice() }}" style="display:none;"></div>

        </div>
    </section>
    <!--/ End Checkout -->

    <!-- Start Shop Services Area  -->
    <section class="shop-services section home">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-rocket"></i>
                        <h4>Free shipping</h4>
                        <p>Orders over ₹1000</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-reload"></i>
                        <h4>Free Return</h4>
                        <p>Within 30 days returns</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-lock"></i>
                        <h4>Secure Payment</h4>
                        <p>100% secure payment</p>
                    </div>
                    <!-- End Single Service -->
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <!-- Start Single Service -->
                    <div class="single-service">
                        <i class="ti-tag"></i>
                        <h4>Best Price</h4>
                        <p>Guaranteed price</p>
                    </div>
                    <!-- End Single Service -->
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop Services -->

    <!-- Start Shop Newsletter  -->
    <section class="shop-newsletter section">
        <div class="container">
            <div class="inner-top">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2 col-12">
                        <!-- Start Newsletter Inner -->
                        <div class="inner">
                            <h4>Newsletter</h4>
                            <p> Subscribe to our newsletter and get <span>10%</span> off your first purchase</p>
                            <form action="mail/mail.php" method="get" target="_blank" class="newsletter-inner">
                                <input name="EMAIL" placeholder="Your email address" required="" type="email">
                                <button class="btn">Subscribe</button>
                            </form>
                        </div>
                        <!-- End Newsletter Inner -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Shop Newsletter -->
@endsection

@push('styles')
    <style>
        li.shipping{
            display: inline-flex;
            width: 100%;
            font-size: 14px;
            flex-direction: column;
            gap: 8px;
        }
        li.shipping .input-group-icon {
            width: 100%;
            margin-left: 10px;
        }
        .input-group-icon .icon {
            position: absolute;
            left: 20px;
            top: 0;
            line-height: 40px;
            z-index: 3;
        }
        .form-select {
            height: 30px;
            width: 100%;
        }
        .form-select .nice-select {
            border: none;
            border-radius: 0px;
            height: 40px;
            background: #f6f6f6 !important;
            padding-left: 12px;
            padding-right: 12px;
            width: 100%;
        }
        .list li{
            margin-bottom:0 !important;
        }
        .list li:hover{
            background:#F7941D !important;
            color:white !important;
        }
        .form-select .nice-select::after {
            top: 14px;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{ asset('frontend/js/nice-select/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // initialize select2 (if used) and nice-select
            $("select.select2").select2();
            $('select.nice-select, select.form-select').niceSelect();
        });
    </script>

    <script>
        $(document).ready(function(){
            function toNumber(value){
                value = (value === undefined || value === null) ? 0 : String(value).replace(/,/g,'');
                return parseFloat(value) || 0;
            }

            function updateTotals(){
                // selected shipping cost
                let $sel = $('#shippingSelect');
                let cost = 0;
                if ($sel.length){
                    cost = toNumber( $sel.find('option:selected').data('price') );
                }

                // subtotal from data-price attribute
                let subtotal = toNumber( $('.order_subtotal').data('price') );

                // coupon may not exist
                let coupon = toNumber( $('.coupon_price').data('price') );

                let total = subtotal + cost - coupon;
                if(total < 0) total = 0;

                // update UI with rupee format
                $('#order_total_price span').text('₹' + total.toFixed(2));
                $('#shippingAmount').text('₹' + cost.toFixed(2));
            }

            // update when shipping changes (works with nice-select because it triggers change on the original select)
            $(document).on('change', '#shippingSelect', function(){
                updateTotals();
            });

            // initialize totals on page load
            updateTotals();
        });
    </script>
@endpush
