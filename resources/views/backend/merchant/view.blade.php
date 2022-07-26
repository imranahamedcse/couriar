@extends('backend.partials.master')
@section('title','Merchants | View')
@section('maincontent')
<!-- ============================================================== -->
<!-- wrapper  -->
<!-- ============================================================== -->
<div class="container-fluid  dashboard-content">
    <!-- ============================================================== -->
    <!-- pageheader -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ __('merchant.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ __('merchantmanage.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('merchant.index') }}" class="breadcrumb-link">{{ __('merchant.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ __('levels.view') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end pageheader -->
    <!-- ============================================================== -->
    <div class="row">
        <!-- ============================================================== -->
        <!-- data table  -->
        <!-- ============================================================== -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="row pl-4 pr-4 pt-4">
                    <div class="col-6">
                    </div>
                </div>

                <div class="card-body">
                   <div class="row">
                    <div class="col-3">
                        <div class="card card-fluid">
                            <!-- .card-body -->
                            <div class="card-body text-center">

                                <!-- .user-avatar -->
                                <a href="#" class="user-avatar user-avatar-xl my-3">
                                  <img src="{{asset($singleMerchant->user->image)}}" alt="User Avatar" class="rounded-circle user-avatar-xl">
                                      </a>
                                <!-- /.user-avatar -->
                                <h3 class="card-title mb-2 text-truncate">
                                    <a href="#">{{$singleMerchant->user->name}}</a>
                                </h3>
                                <h6 class="card-subtitle text-muted mb-3"> {{ __('levels.email') }}: {{$singleMerchant->user->email}}</h6>
                                <h6 class="card-subtitle text-muted mb-3"> {{ __('levels.phone') }}: {{$singleMerchant->user->mobile}}</h6>

                            </div>
                            <div class="list-group list-group-flush">
                                <a href="{{ route('merchant.view',$singleMerchant->id) }}" class="list-group-item list-group-item-action {{ (request()->is('admin/merchant/view/'.$singleMerchant->id)) ? 'active' : '' }}">{{ __('merchant.company_information') }}</a>
                            @if(hasPermission('merchant_delivery_charge_read') == true )
                                <a href="{{ route('merchant.deliveryCharge.index',$singleMerchant->id) }}" class="list-group-item list-group-item-action {{ (request()->is('admin/merchant/'.$singleMerchant->id.'/delivery-charge*')) ? 'active' : '' }}">{{ __('merchant.delivery_charge') }}</a>
                            @endif
                            @if(hasPermission('merchant_shop_read') == true )
                                <a href="{{ route('merchant.shops.index',$singleMerchant->id) }}" class="list-group-item list-group-item-action {{ (request()->is('admin/merchant/'.$singleMerchant->id.'/shops*','admin/merchant/shops*')) ? 'active' : '' }}">{{ __('merchant.shop') }}</a>
                            @endif
                            @if(hasPermission('merchant_payment_read') == true )
                                <a href="{{ route('merchant.paymentaccount.index',$singleMerchant->id) }}" class="list-group-item list-group-item-action {{ (request()->is('admin/merchant/'.$singleMerchant->id.'/payment*')) ? 'active' : '' }}">{{ __('merchant.payment_account') }}</a>
                            @endif
                            </div>
                            <!-- /.card-body -->
                            <!-- .card-footer -->
                            <footer class="card-footer p-0">
                                <div class="row">
                                    <div class="col-md-3">
                                        <!-- .card-footer-item -->
                                        <div class="card-footer-item-bordered">
                                            <!-- .metric -->
                                            <div class="metric">
                                                <h6 class="metric-value"> {{ settings()->currency }} {{ $singleMerchant->parcels->count()}} </h6>
                                                <p class="metric-label">{{__('parcel.title')}} </p>
                                            </div>
                                            <!-- /.metric -->
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <!-- .-->
                                        <div class="card-footer-item-bordered">
                                            <!-- .metric -->
                                            <div class="metric">
                                                <h6 class="metric-value"> {{ settings()->currency }}  {{ $singleMerchant->parcels->sum('cash_collection') }} </h6>
                                                <p class="metric-label"> {{ __('merchant.amount') }} </p>
                                            </div>
                                            <!-- /.metric -->
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <!-- .-->
                                        <div class="card-footer-item-bordered">
                                            <!-- .metric -->
                                            <div class="metric">
                                                <h6 class="metric-value">{{ settings()->currency }} {{ $singleMerchant->parcels->sum('current_payable') }}</h6>
                                                <p class="metric-label">{{ __('merchant.payble_amount') }} </p>
                                            </div>
                                            <!-- /.metric -->
                                        </div>
                                    </div>
                                </div>
                            </footer>
                            <!-- /.card-footer -->
                        </div>
                    </div>
                    <div class="col-9">
                        @yield('backend.merchant.layout.list')
                    </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- end wrapper  -->
<!-- ============================================================== -->
@endsection();



<!-- css  -->
@push('styles')
@endpush
<!-- js  -->
@push('scripts')
@endpush


