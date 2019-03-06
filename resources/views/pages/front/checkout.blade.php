@extends('layouts.main')

@section('content')
    @include('partials.hero')

    <div class="ps-checkout">
        <div class="ps-container">
            <form class="ps-form--checkout" action="do_action" method="post">
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 ">
                        <div class="ps-checkout__billing">
                            <h3>Billing Details</h3>
                            <div class="form-group form-group--inline">
                                <label>First Name<span>*</span>
                                </label>
                                <div class="form-group__content">
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="form-group form-group--inline">
                                <label>Last Name<span>*</span>
                                </label>
                                <div class="form-group__content">
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="form-group form-group--inline">
                                <label>Company Name<span>*</span>
                                </label>
                                <div class="form-group__content">
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="form-group form-group--inline">
                                <label>Email Address<span>*</span>
                                </label>
                                <div class="form-group__content">
                                    <input class="form-control" type="email">
                                </div>
                            </div>
                            <div class="form-group form-group--inline">
                                <label>Company Name<span>*</span>
                                </label>
                                <div class="form-group__content">
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="form-group form-group--inline">
                                <label>Phone<span>*</span>
                                </label>
                                <div class="form-group__content">
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="form-group form-group--inline">
                                <label>Address<span>*</span>
                                </label>
                                <div class="form-group__content">
                                    <input class="form-control" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="ps-checkbox">
                                    <input class="form-control" type="checkbox" id="cb01">
                                    <label for="cb01">Create an account?</label>
                                </div>
                            </div>
                            <h3 class="mt-40"> Addition information</h3>
                            <div class="form-group form-group--inline textarea">
                                <label>Order Notes</label>
                                <textarea class="form-control" rows="7" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 ">
                        <div class="ps-checkout__order">
                            <header>
                                <h3>Your Order</h3>
                            </header>
                            <div class="content">
                                <table class="table ps-checkout__products">
                                    <thead>
                                    <tr>
                                        <th class="text-uppercase">Product</th>
                                        <th class="text-uppercase">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>HABITANT x1</td>
                                        <td>$300.00</td>
                                    </tr>
                                    <tr>
                                        <td>Card Subtitle</td>
                                        <td>$300.00</td>
                                    </tr>
                                    <tr>
                                        <td>Order Total</td>
                                        <td>$300.00</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <footer>
                                <h3>Payment Method</h3>
                                <div class="form-group cheque">
                                    <div class="ps-radio ps-radio--small">
                                        <input class="form-control" type="radio" id="rdo01" name="payment" checked>
                                        <label for="rdo01">Payment on Delivery</label>
                                    </div>
                                    <p>Please send your cheque to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</p>
                                </div>
                                <div class="form-group paypal">
                                    <div class="ps-radio ps-radio--small">
                                        <input class="form-control" type="radio" name="payment" id="rdo02">
                                        <label for="rdo02">Online</label>
                                    </div>
                                    <ul class="ps-payment-method">
                                        <li><a href="#"><img src="images/payment/1.png" alt=""></a></li>
                                        <li><a href="#"><img src="images/payment/2.png" alt=""></a></li>
                                        <li><a href="#"><img src="images/payment/3.png" alt=""></a></li>
                                    </ul>
                                    <button class="ps-btn ps-btn--fullwidth">Place Order</button>
                                </div>
                            </footer>
                        </div>
                        <div class="ps-shipping">
                            <h3>FREE SHIPPING</h3>
                            <p>YOUR ORDER QUALIFIES FOR FREE SHIPPING.<br> <a href="#"> Singup </a> for free shipping on every order, every time.</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')

    @endpush