@extends('backend.partials.master')
@section('title','Parcels | Details')
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
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ __('levels.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('parcel.index')}}" class="breadcrumb-link">{{ __('parcel.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{__('levels.details')}}</a></li>
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
                <div class="card-header">
                    <p class="h3">Parcel Details</p>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                         <!-- Parcel details -->
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <td class="parcel_details_title" colspan="2"><strong>{{__('parcel.merchant_details')}}</strong></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{__('levels.merchant_unique_id')}}</td>
                                            <td>{{$parcel->merchant->merchant_unique_id}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('merchant.business_name')}}</td>
                                            <td>{{$parcel->merchant->business_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('levels.name')}}</td>
                                            <td>{{$parcel->merchant->user->name}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('levels.mobile')}}</td>
                                            <td>{{$parcel->merchant->user->mobile}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('levels.address')}}</td>
                                            <td>{{$parcel->merchant->address}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('levels.email')}}</td>
                                            <td>{{$parcel->merchant->user->email}}</td>
                                        </tr>
                                        <!-- Parcel shop details -->
                                        <thead>
                                            <tr>
                                                <td class="parcel_sub_table" colspan="2"><strong>{{__('parcel.merchant_shop_details')}}</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{__('levels.name')}}</td>
                                                <td>{{$parcel->merchantShop->name}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('levels.mobile')}}</td>
                                                <td>{{$parcel->merchantShop->contact_no}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('levels.address')}}</td>
                                                <td>{{$parcel->merchantShop->address}}</td>
                                            </tr>
                                        </tbody>
                                        <!-- Parcel end shop details -->
                                        <!-- Parcel pickup details -->
                                        <thead>
                                            <tr>
                                                <td class="parcel_sub_table" colspan="2"><strong>{{__('parcel.pickup_details')}}</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{__('levels.name')}}</td>
                                                <td>{{$parcel->merchantShop->name}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('levels.mobile')}}</td>
                                                <td>{{$parcel->pickup_phone}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('levels.address')}}</td>
                                                <td>{{$parcel->pickup_address}}</td>
                                            </tr>
                                        </tbody>
                                        <!-- Parcel end pickup details -->
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-striped table-sm">
                                    <!-- Parcel customer details -->
                                    <thead>
                                        <tr>
                                            <td class="parcel_details_title" colspan="2"><strong>{{__('parcel.customer_details')}}</strong></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{__('levels.name')}}</td>
                                            <td>{{$parcel->customer_name}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('levels.mobile')}}</td>
                                            <td>{{$parcel->customer_phone}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('levels.address')}}</td>
                                            <td>{{$parcel->customer_address}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('merchant.invoice')}}</td>
                                            <td>{{$parcel->invoice_no}}</td>
                                        </tr>
                                        <tr>
                                            <td>{{__('merchant.track_id')}}</td>
                                            <td>{{$parcel->tracking_id}}</td>
                                        </tr>
                                        <thead>
                                            <tr>
                                                <td class="parcel_sub_table" colspan="4"><strong>{{__('parcel.parcel_details')}}</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td >{{__('parcel.pickup_time')}}</td>
                                                <td class="active" colspan="3">{{dateFormat($parcel->pickup_date)}}</td>
                                                {{-- <td class="highlight" colspan="3">{{dateFormat($parcel->pickup_date)}}</td> --}}
                                            </tr>
                                                <td >{{__('parcel.delivert_time')}}</td>
                                                <td class="active" colspan="3">{{dateFormat($parcel->delivery_date)}}</td>
                                                {{-- <td class="highlight" colspan="3">{{dateFormat($parcel->delivery_date)}}</td> --}}
                                            </tr>

                                            <tr>
                                                <td>{{__('levels.delivery_category')}}</td>
                                                <td>{{$parcel->deliveryCategory->title}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('levels.weight')}}</td>
                                                <td>{{$parcel->weight}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('levels.delivery_type')}}</td>
                                                <td>
                                                    {{ $parcel->delivery_type_name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{__('levels.packaging_title')}}</td>
                                                <td>{{@$parcel->packaging->name}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('levels.packaging_price')}}</td>
                                                <td>{{@$parcel->packaging->price}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('levels.cash_collection')}}</td>
                                                <td>{{$parcel->cash_collection}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('levels.selling_price')}}</td>
                                                <td>{{$parcel->selling_price}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('levels.liquid_fragile_amount')}}</td>
                                                <td>{{$parcel->liquid_fragile_amount}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('levels.packaging_amount')}}</td>
                                                <td>{{$parcel->packaging_amount}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('levels.delivery_charge')}}</td>
                                                <td>{{$parcel->delivery_charge}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('levels.cod_charge')}}</td>
                                                <td>{{$parcel->cod_charge}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('levels.cod_amount')}}</td>
                                                <td>{{$parcel->cod_amount}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('levels.vat')}}</td>
                                                <td>{{$parcel->vat}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('levels.vat_amount')}}</td>
                                                <td>{{$parcel->vat_amount}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('levels.total_delivery_amount')}}</td>
                                                <td>{{$parcel->total_delivery_amount}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('levels.current_payable')}}</td>
                                                <td>{{$parcel->current_payable}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{__('levels.note')}}</td>
                                                <td colspan="3">{{$parcel->note}}</td>
                                            </tr>

                                        </tbody>
                                    </tbody>
                                    <!-- Parcel end customer details -->
                                    <!-- Parcel Details -->

                                    <!-- Parcel end Details -->
                                </table>

                            </div>
                        </div>
                        <!-- End Parcel details -->
                    </div>
                    <!-- Parcel Logs -->
                    <div class="row">
                        <div class="col-md-12">


                            <section class="cd-timeline js-cd-timeline">
                                <div class="cd-timeline__container">

                                    @foreach ($parcelevents as $log)
                                    @switch($log->parcel_status)
                                        @case(\App\Enums\ParcelStatus::PICKUP_ASSIGN)

                                            <div class="cd-timeline__block js-cd-block">
                                                <div class="cd-timeline__img cd-timeline__img--picture js-cd-img">
                                                    <i class="timeline_icon fas fa-check" aria-hidden="true"></i>
                                                </div>
                                                <!-- cd-timeline__img -->
                                                <div class="cd-timeline__content js-cd-content">
                                                    <strong>{{__('parcelLogs.'.$log->parcel_status)}}</strong><br>
                                                    <span>{{__('parcel.pickup_man')}}: {{isset($log->pickupman)? $log->pickupman->user->name:''}}</span><br>
                                                    <span>{{__('levels.mobile')}}: {{isset($log->pickupman)? $log->pickupman->user->mobile:''}}</span><br>
                                                    <span>{{__('levels.note')}}: {{$log->note}}</span><br/>

                                                    <strong>{{ __('levels.created_by') }}</strong><br/>
                                                    <span>{{ __('levels.name') }}: {{ $log->user->name }} </span><br/>
                                                    <span>{{ __('levels.mobile') }}: {{ $log->user->mobile }} </span>

                                                    <div class="cd-timeline__date">
                                                        <strong>{!! dateFormat($log->created_at) !!}</strong><br>
                                                        <small>{!! date('h:i a', strtotime($log->created_at)) !!}</small>
                                                    </div>
                                                </div>
                                                <!-- cd-timeline__content -->
                                            </div>
                                        @break
                                        @case(\App\Enums\ParcelStatus::PICKUP_RE_SCHEDULE)
                                            <div class="cd-timeline__block js-cd-block">
                                                <div class="cd-timeline__img cd-timeline__yellow js-cd-img">
                                                    <i class="timeline_icon fas fa-hourglass-end" aria-hidden="true"></i>
                                                </div>
                                                <!-- cd-timeline__img -->
                                                <div class="cd-timeline__content js-cd-content">
                                                    <strong>{{__('parcelLogs.'.$log->parcel_status)}}</strong><br>
                                                    <span>{{__('parcel.pickup_man')}}: {{isset($log->pickupman)? $log->pickupman->user->name:''}}</span><br>
                                                    <span>{{__('levels.mobile')}}: {{isset($log->pickupman)? $log->pickupman->user->mobile:''}}</span><br>
                                                    <span>{{__('levels.note')}}: {{$log->note}}</span><br/>

                                                    <strong>{{ __('levels.created_by') }}</strong><br/>
                                                    <span>{{ __('levels.name') }}: {{ $log->user->name }} </span><br/>
                                                    <span>{{ __('levels.mobile') }}: {{ $log->user->mobile }} </span>


                                                    <div class="cd-timeline__date">
                                                        <strong>{!! dateFormat($log->created_at) !!}</strong><br>
                                                        <small>{!! date('h:i a', strtotime($log->created_at)) !!}</small>
                                                    </div>
                                                </div>
                                                <!-- cd-timeline__content -->
                                            </div>
                                        @break
                                        @case(\App\Enums\ParcelStatus::RECEIVED_BY_PICKUP_MAN)
                                            <div class="cd-timeline__block js-cd-block">
                                                <div class="cd-timeline__img cd-timeline__img--picture js-cd-img">
                                                    <i class="timeline_icon fas fa-check" aria-hidden="true"></i>
                                                </div>
                                                <!-- cd-timeline__img -->
                                                <div class="cd-timeline__content js-cd-content">
                                                    <strong>{{__('parcelLogs.'.$log->parcel_status)}}</strong><br>
                                                    <span>{{__('levels.note')}}: {{$log->note}}</span><br/>

                                                    <strong>{{ __('levels.created_by') }}</strong><br/>
                                                    <span>{{ __('levels.name') }}: {{ $log->user->name }} </span><br/>
                                                    <span>{{ __('levels.mobile') }}: {{ $log->user->mobile }} </span>


                                                    <div class="cd-timeline__date">
                                                        <strong>{!! dateFormat($log->created_at) !!}</strong><br>
                                                        <small>{!! date('h:i a', strtotime($log->created_at)) !!}</small>
                                                    </div>
                                                </div>
                                                <!-- cd-timeline__content -->
                                            </div>
                                        @break
                                        @case(\App\Enums\ParcelStatus::RECEIVED_WAREHOUSE)
                                            <div class="cd-timeline__block js-cd-block">
                                                <div class="cd-timeline__img cd-timeline__img--picture js-cd-img">
                                                    <i class="timeline_icon fas fa-check" aria-hidden="true"></i>
                                                </div>
                                                <!-- cd-timeline__img -->
                                                <div class="cd-timeline__content js-cd-content">
                                                    <strong>{{__('parcelLogs.'.$log->parcel_status)}}</strong><br>
                                                    <span>{{__('parcelLogs.hub_name')}}: {{$log->hub->name}}</span><br>
                                                    <span>{{__('levels.mobile')}}: {{$log->hub->phone}}</span><br/>
                                                    <span>{{__('levels.note')}}: {{$log->note}}</span><br/>

                                                    <strong>{{ __('levels.created_by') }}</strong><br/>
                                                    <span>{{ __('levels.name') }}: {{ $log->user->name }} </span><br/>
                                                    <span>{{ __('levels.mobile') }}: {{ $log->user->mobile }} </span>


                                                    <div class="cd-timeline__date">
                                                        <strong>{!! dateFormat($log->created_at) !!}</strong><br>
                                                        <small>{!! date('h:i a', strtotime($log->created_at)) !!}</small>
                                                    </div>
                                                </div>
                                                <!-- cd-timeline__content -->
                                            </div>
                                        @break
                                        @case(\App\Enums\ParcelStatus::TRANSFER_TO_HUB)
                                            <div class="cd-timeline__block js-cd-block">
                                                <div class="cd-timeline__img cd-timeline__img--picture js-cd-img">
                                                    <i class="timeline_icon fas fa-check" aria-hidden="true"></i>
                                                </div>
                                                <!-- cd-timeline__img -->
                                                <div class="cd-timeline__content js-cd-content">
                                                    <strong>{{__('parcelLogs.'.$log->parcel_status)}}</strong><br>
                                                    <span>{{__('parcelLogs.hub_name')}}: {{$log->hub->name}}</span><br>
                                                    <span>{{__('parcelLogs.hub_phone')}}: {{$log->hub->phone}}</span><br/>
                                                    <span>{{__('parcelLogs.delivery_man')}}: {{isset( $log->transferDeliveryman) ? $log->transferDeliveryman->user->name:''}}</span><br/>
                                                    <span>{{__('parcelLogs.delivery_man_phone')}}: {{isset( $log->transferDeliveryman)  ? $log->transferDeliveryman->user->mobile:''}}</span><br/>
                                                    <span>{{__('levels.note')}}: {{$log->note}}</span><br/>

                                                    <strong>{{ __('levels.created_by') }}</strong><br/>
                                                    <span>{{ __('levels.name') }}: {{ $log->user->name }} </span><br/>
                                                    <span>{{ __('levels.mobile') }}: {{ $log->user->mobile }} </span>


                                                    <div class="cd-timeline__date">
                                                        <strong>{!! dateFormat($log->created_at) !!}</strong><br>
                                                        <small>{!! date('h:i a', strtotime($log->created_at)) !!}</small>
                                                    </div>
                                                </div>
                                                <!-- cd-timeline__content -->
                                            </div>
                                        @break
                                        @case(\App\Enums\ParcelStatus::DELIVERY_MAN_ASSIGN)
                                            <div class="cd-timeline__block js-cd-block">
                                                <div class="cd-timeline__img cd-timeline__img--picture js-cd-img">
                                                    <i class="timeline_icon fas fa-check" aria-hidden="true"></i>
                                                </div>
                                                <!-- cd-timeline__img -->
                                                <div class="cd-timeline__content js-cd-content">
                                                    <strong>{{__('parcelLogs.'.$log->parcel_status)}}</strong><br>
                                                    <span>{{__('parcelLogs.delivery_man')}}: {{isset($log->deliveryMan)? $log->deliveryMan->user->name:''}}</span><br>
                                                    <span>{{__('levels.phone')}}: {{isset($log->deliveryMan)? $log->deliveryMan->user->mobile:''}}</span><br/>
                                                    <span>{{__('levels.note')}}: {{$log->note}}</span><br/>

                                                    <strong>{{ __('levels.created_by') }}</strong><br/>
                                                    <span>{{ __('levels.name') }}: {{ $log->user->name }} </span><br/>
                                                    <span>{{ __('levels.mobile') }}: {{ $log->user->mobile }} </span>


                                                    <div class="cd-timeline__date">
                                                        <strong>{!! dateFormat($log->created_at) !!}</strong><br>
                                                        <small>{!! date('h:i a', strtotime($log->created_at)) !!}</small>
                                                    </div>
                                                </div>
                                                <!-- cd-timeline__content -->
                                            </div>
                                        @break

                                        @case(\App\Enums\ParcelStatus::DELIVERY_RE_SCHEDULE)
                                            <div class="cd-timeline__block js-cd-block">
                                                 <div class="cd-timeline__img cd-timeline__yellow js-cd-img">
                                                    <i class="timeline_icon fas fa-hourglass-end" aria-hidden="true"></i>
                                                </div>
                                                <!-- cd-timeline__img -->
                                                <div class="cd-timeline__content js-cd-content">
                                                    <strong>{{__('parcelLogs.'.$log->parcel_status)}}</strong><br>
                                                    <span>{{__('parcelLogs.delivery_man')}}: {{isset($log->deliveryMan)? $log->deliveryMan->user->name:''}}</span><br>
                                                    <span>{{__('levels.phone')}}: {{isset($log->deliveryMan)? $log->deliveryMan->user->mobile:''}}</span><br/>
                                                    <span>{{__('levels.note')}}: {{$log->note}}</span><br/>

                                                    <strong>{{ __('levels.created_by') }}</strong><br/>
                                                    <span>{{ __('levels.name') }}: {{ $log->user->name }} </span><br/>
                                                    <span>{{ __('levels.mobile') }}: {{ $log->user->mobile }} </span>


                                                    <div class="cd-timeline__date">
                                                        <strong>{!! dateFormat($log->created_at) !!}</strong><br>
                                                        <small>{!! date('h:i a', strtotime($log->created_at)) !!}</small>
                                                    </div>
                                                </div>
                                                <!-- cd-timeline__content -->
                                            </div>
                                        @break
                                        @case(\App\Enums\ParcelStatus::DELIVERED)
                                            <div class="cd-timeline__block js-cd-block">
                                                <div class="cd-timeline__img cd-timeline__img--picture js-cd-img">
                                                    <i class="timeline_icon fas fa-check" aria-hidden="true"></i>
                                                </div>
                                                <!-- cd-timeline__img -->
                                                <div class="cd-timeline__content js-cd-content">
                                                    <strong>{{__('parcelLogs.'.$log->parcel_status)}}</strong><br>
                                                    <span>{{__('levels.note')}}: {{$log->note}}</span><br/>

                                                    <strong>{{ __('levels.created_by') }}</strong><br/>
                                                    <span>{{ __('levels.name') }}: {{ $log->user->name }} </span><br/>
                                                    <span>{{ __('levels.mobile') }}: {{ $log->user->mobile }} </span>


                                                    <div class="cd-timeline__date">
                                                        <strong>{!! dateFormat($log->created_at) !!}</strong><br>
                                                        <small>{!! date('h:i a', strtotime($log->created_at)) !!}</small>
                                                    </div>
                                                </div>
                                                <!-- cd-timeline__content -->
                                            </div>
                                        @break
                                        @case(\App\Enums\ParcelStatus::PARTIAL_DELIVERED)
                                            <div class="cd-timeline__block js-cd-block">
                                                <div class="cd-timeline__img cd-timeline__img--picture js-cd-img">
                                                    <i class="timeline_icon fas fa-check" aria-hidden="true"></i>
                                                </div>
                                                <!-- cd-timeline__img -->
                                                <div class="cd-timeline__content js-cd-content">
                                                    <strong>{{__('parcelLogs.'.$log->parcel_status)}}</strong><br>
                                                    <span>{{__('levels.note')}}: {{$log->note}}</span><br/>

                                                    <strong>{{ __('levels.created_by') }}</strong><br/>
                                                    <span>{{ __('levels.name') }}: {{ $log->user->name }} </span><br/>
                                                    <span>{{ __('levels.mobile') }}: {{ $log->user->mobile }} </span>


                                                    <div class="cd-timeline__date">
                                                        <strong>{!! dateFormat($log->created_at) !!}</strong><br>
                                                        <small>{!! date('h:i a', strtotime($log->created_at)) !!}</small>
                                                    </div>
                                                </div>
                                                <!-- cd-timeline__content -->
                                            </div>
                                        @break
                                        @case(\App\Enums\ParcelStatus::RETURN_MERCHANT_RE_SCHEDULE)
                                        <div class="cd-timeline__block js-cd-block">
                                            <div class="cd-timeline__img cd-timeline__yellow js-cd-img">
                                                <i class="timeline_icon fas fa-hourglass-end" aria-hidden="true"></i>
                                            </div>
                                           <!-- cd-timeline__img -->
                                           <div class="cd-timeline__content js-cd-content">
                                            <strong>{{__('parcelLogs.'.$log->parcel_status)}}</strong><br>
                                            <span>{{__('levels.note')}}: {{$log->note}}</span><br/>

                                            <strong>{{ __('levels.created_by') }}</strong><br/>
                                            <span>{{ __('levels.name') }}: {{ $log->user->name }} </span><br/>
                                            <span>{{ __('levels.mobile') }}: {{ $log->user->mobile }} </span>


                                            <div class="cd-timeline__date">
                                                <strong>{!! dateFormat($log->created_at) !!}</strong><br>
                                                <small>{!! date('h:i a', strtotime($log->created_at)) !!}</small>
                                            </div>
                                        </div>
                                        <!-- cd-timeline__content -->
                                        </div>
                                    @break
                                        @default
                                            <div class="cd-timeline__block js-cd-block">
                                                <div class="cd-timeline__img cd-timeline__img--picture js-cd-img">
                                                    <i class="timeline_icon fas fa-check" aria-hidden="true"></i>
                                                </div>
                                                <!-- cd-timeline__img -->
                                                <div class="cd-timeline__content js-cd-content">
                                                    <strong>{{__('parcelLogs.'.$log->parcel_status)}}</strong><br>
                                                    <span>{{__('levels.note')}}: {{$log->note}}</span><br/>

                                                    <strong>{{ __('levels.created_by') }}</strong><br/>
                                                    <span>{{ __('levels.name') }}: {{ $log->user->name }} </span><br/>
                                                    <span>{{ __('levels.mobile') }}: {{ $log->user->mobile }} </span>


                                                    <div class="cd-timeline__date">
                                                        <strong>{!! dateFormat($log->created_at) !!}</strong><br>
                                                        <small>{!! date('h:i a', strtotime($log->created_at)) !!}</small>
                                                    </div>
                                                </div>
                                                <!-- cd-timeline__content -->
                                            </div>
                                        @endswitch
                                    @endforeach


                                    <div class="cd-timeline__block js-cd-block">
                                        <div class="cd-timeline__img cd-timeline__img--picture js-cd-img">
                                            <i class="timeline_icon fas fa-check" aria-hidden="true"></i>
                                        </div>
                                        <!-- cd-timeline__img -->
                                        <div class="cd-timeline__content js-cd-content">
                                            <strong>{{__('parcel.parcel_create')}}</strong><br>
                                            <span>{{__('levels.name')}}: {{$parcel->merchant->user->name}}</span><br>
                                            <span>{{__('levels.email')}}: {{$parcel->merchant->user->email}}</span><br>
                                            <span>{{__('levels.mobile')}}: {{$parcel->merchant->user->mobile}}</span>

                                            <div class="cd-timeline__date">
                                                <strong>{!! dateFormat($parcel->created_at) !!}</strong><br>
                                                <small>{!! date('h:i a', strtotime($parcel->created_at)) !!}</small>
                                            </div>
                                        </div>
                                        <!-- cd-timeline__content -->
                                    </div>


                                </div>
                            </section>
                            <!-- cd-timeline -->
                        </div>
                    </div>
                    <!-- End Parcel Logs -->
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end data table  -->
        <!-- ============================================================== -->
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


