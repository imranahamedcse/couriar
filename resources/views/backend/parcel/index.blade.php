@extends('backend.partials.master')
@section('title','Parcels | List')
@section('maincontent')
<!-- ============================================================== -->
<!-- wrapper  -->
<!-- ============================================================== -->
<div class="container-fluid  dashboard-content">
    <!-- ============================================================== -->
    <!-- pageheader -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ __('menus.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('parcel.index') }}" class="breadcrumb-link">{{ __('parcel.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link active">{{ __('menus.menu') }}</a></li>
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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('parcel.filter')}}"  method="GET">
                        @csrf
                        <div class="row">
                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-3">
                                <label for="parcel_date">{{ __('parcel.date') }}</label>
                                <input type="text" autocomplete="off" id="date" name="parcel_date" class="form-control date_range_picker" value="{{ old('parcel_date',$request->parcel_date) }}">

                                @error('parcel_date')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-3">
                                <label for="pickup_date">{{ __('parcel.pickup_date') }}</label>
                                <input type="date" id="pickup_date"  data-toggle="datepicker" name="pickup_date" data-parsley-trigger="change" placeholder="yyyy-mm-dd"  class="form-control" value="{{old('pickup_date',$request->pickup_date)}}" >

                                @error('pickup_date')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-3">
                                <label for="delivery_date">{{ __('parcel.delivery_date') }}</label>
                                <input type="date" id="delivery_date"  data-toggle="datepicker" name="delivery_date" data-parsley-trigger="change" placeholder="yyyy-mm-dd"  class="form-control" value="{{old('delivery_date',$request->delivery_date)}}" >
                                @error('delivery_date')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-3">
                                <label for="parcelStatus">{{ __('parcel.status') }}</label>
                                <select style="width: 100%" id="parcelStatus"  name="parcel_status" class="form-control @error('parcel_status') is-invalid @enderror" >
                                    <option value="" selected> {{ __('menus.select') }} {{ __('levels.status') }}</option>
                                    @foreach (trans('parcelStatusFilter') as $key => $status)
                                        <option value="{{ $key}}" {{ (old('parcel_status',$request->parcel_status) == $key) ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                                @error('parcel_status')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-3">
                                <label for="parcelMerchantid">{{ __('parcel.merchant') }}</label>
                                <select style="width: 100%" id="parcelMerchantid"  name="parcel_merchant_id" class="form-control @error('parcel_merchant_id') is-invalid @enderror" data-url="{{ route('parcel.merchant.shops') }}">
                                    <option value=""> {{ __('menus.select') }} {{ __('merchant.title') }}</option>

                                </select>
                                @error('parcel_merchant_id')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-3">
                                <label for="parcelDeliveryManID">{{ __('parcel.deliveryman') }}</label>
                                <select style="width: 100%" id="parcelDeliveryManID"  name="parcel_deliveryman_id" data-url="{{ route('parcel.deliveryman.search') }}" class="form-control @error('parcel_deliveryman_id') is-invalid @enderror">
                                    <option value="">{{ __('menus.select') }} {{ __('deliveryman.title') }}</option>

                                </select>
                                @error('parcel_deliveryman_id')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-3">
                                <label for="parcelPickupmanId">{{ __('parcel.pickupman') }}</label>
                                <select style="width: 100%" id="parcelPickupmanId"  name="parcel_pickupman_id" data-url="{{ route('parcel.deliveryman.search') }}" class="form-control @error('parcel_pickupman_id') is-invalid @enderror" >
                                    <option value=""> {{ __('menus.select') }} {{ __('parcel.pickup_man') }}</option>

                                </select>
                                @error('parcel_pickupman_id')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-4 col-lg-3 pt-1">
                                <div class="col-12 pt-4 d-flex justify-content">
                                    <button type="submit" class="btn btn-sm btn-space btn-primary"><i class="fa fa-filter"></i> {{ __('levels.filter') }}</button>
                                    <a href="{{ route('parcel.index') }}" class="btn btn-sm btn-space btn-secondary"><i class="fa fa-eraser"></i> {{ __('levels.clear') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="row pl-4 pr-4 pt-4">
                    <div class="col-12 col-lg-6">
                        <div class="d-flex justify-content-between parcelsearchFlex">
                            <p class="h3">{{ __('parcel.title') }} </p>
                            <input id="Psearch" class="form-control parcelSearch" type="text" placeholder="{{ __('levels.search') }}...">
                        </div>
                    </div>
                    @if(hasPermission('parcel_create'))
                    <div class="col-12 col-lg-6 mt-2 mt-lg-0">
                        <div class="text-right">


                            <select class="input p-2 select2 select-bulk-type" id="selectAssignType">
                                <option>{{ __('levels.select_bulk_type') }}</option>
                                <option value="assignpickupbulk">{{ __('levels.assign_pickup') }}</option>
                                <option value="transfer_to_hub_multiple_parcel">{{ __('levels.hub_transfer') }}</option>
                                <option value="received_by_hub_multiple_parcel">{{ __('levels.received_by_hub') }}</option>
                                <option value="delivery_man_assign_multiple_parcel">{{ __('levels.delivery_man_assign') }}</option>
                                <option value="assign_return_merchant">{{ __('levels.assign_return_merchant') }}</option>
                            </select>

                            <a href="{{route('parcel.parcel-import')}}" class="btn btn-sm btn-info ml-1 mb-1" data-toggle="tooltip" data-placement="top" title="Parcel Import"><i class="fa fa-plus"></i> {{ __('parcel.import_parcel') }}</a>
                            <a href="{{route('parcel.create')}}" class="btn btn-sm btn-primary ml-1 mb-1" data-toggle="tooltip" data-placement="top" title="Add"><i class="fa fa-plus"></i> {{ __('levels.add') }}</a>
                        </div>
                    </div>
                    @endif
                </div>
                {{-- <div class="row px-4">
                    <div class="col-12 text-right">

                    </div>
                </div> --}}

                <div class="card-body">
                    <div class="table-responsive">

                        <table id="table" class="table table-striped parcelTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th>{{ __('###') }}</th>
                                    <th>{{ __('parcel.customer_info') }}</th>
                                    <th>{{ __('parcel.merchant') }}</th>
                                    <th>{{ __('parcel.parcel_info')}}</th>
                                    <th>{{ __('parcel.status') }}</th>
                                    @if(hasPermission('parcel_status_update') == true)
                                        <th>{{ __('parcel.status_update') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach($parcels as $parcel)
                                <tr>
                                    <td>
                                        <div class="row">
                                            <button tabindex="-1" data-toggle="dropdown" type="button" class="btn btn-sm ml-2">...</button>
                                            <div class="dropdown-menu">
                                                <a href="{{ route('parcel.details',$parcel->id) }}" class="dropdown-item"><i class="fa fa-eye" aria-hidden="true"></i> {{__('levels.details')}}</a>
                                                <a href="{{ route('parcel.logs',$parcel->id) }}" class="dropdown-item"><i class="fas fa-history" aria-hidden="true"></i> {{__('levels.parcel_logs')}}</a>
                                                <a href="{{ route('parcel.clone',$parcel->id) }}" class="dropdown-item"><i class="fas fa-clone" aria-hidden="true"></i> {{__('levels.clone')}}</a>
                                                <a href="{{ route('parcel.print',$parcel->id) }}" class="dropdown-item"><i class="fas fa-print" aria-hidden="true"></i> {{__('levels.print')}}</a>
                                                <a href="{{ route('parcel.print-label',$parcel->id) }}" target="_blank" class="dropdown-item"><i class="fas fa-print" aria-hidden="true"></i> {{__('levels.print_label')}}</a>

                                            @if(hasPermission('parcel_update') == true)
                                                <a href="{{route('parcel.edit',$parcel->id)}}" class="dropdown-item"><i class="fas fa-edit" aria-hidden="true"></i> {{__('levels.edit')}}</a>
                                            @endif
                                            @if(hasPermission('parcel_delete'))
                                                <form id="delete" value="Test" action="{{route('parcel.delete',$parcel->id)}}" method="POST" data-title="{{ __('delete.parcel') }}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <input type="hidden" name="" value="Parcel" id="deleteTitle">
                                                    <button type="submit" class="dropdown-item"><i class="fa fa-trash" aria-hidden="true"></i> {{ __('levels.delete') }}</button>
                                                </form>
                                            @endif

                                            </div>
                                        </div>
                                    </td>
                                    <td class="merchantpayment">
                                        <p>{{$parcel->customer_name}}</p>
                                        <p>{{$parcel->customer_phone}}</p>
                                        <p>{{$parcel->customer_address}}</p>
                                    </td>
                                    <td class="merchantpayment">
                                        <p>{{$parcel->merchant->business_name}}</p>
                                        <p>{{$parcel->merchant->user->mobile}}</p>
                                        <p>{{$parcel->merchant->address}}</p>
                                    </td>
                                    <td>
                                        {{__('levels.track_id')}}: <span class="active">{{ $parcel->tracking_id }}</span>
                                        <br>
                                        {{__('levels.delivery_type')}}: {{ $parcel->delivery_type_name }}
                                        <br>
                                        {{__('parcel.pickup_time')}}: {{dateFormat($parcel->pickup_date)}}
                                        <br>
                                        {{__('parcel.delivert_time')}}: {{dateFormat($parcel->delivery_date)}}
                                        <br>
                                        {{__('levels.total_delivery_amount')}}: <span class="text-dark">{{settings()->currency}}{{$parcel->total_delivery_amount}}</span>
                                        <br>
                                        {{__('levels.vat_amount')}}: <span class="text-dark">{{settings()->currency}}{{$parcel->vat_amount}}</span>
                                        <br>
                                        {{__('levels.current_payable')}}: <span class="text-dark">{{settings()->currency}}{{$parcel->current_payable}}</span>
                                        <br>
                                        {{__('levels.cash_collection')}}: <span class="text-dark">{{settings()->currency}}{{$parcel->cash_collection}}</span>
                                    </td>
                                    <td>{!! $parcel->parcel_status !!} <br>
                                        @if($parcel->partial_delivered && $parcel->status != \App\Enums\ParcelStatus::PARTIAL_DELIVERED)
                                        <span class="badge badge-pill badge-success mt-2">{{trans("parcelStatus." . \App\Enums\ParcelStatus::PARTIAL_DELIVERED)}}</span>
                                    @endif
                                    </td>
                                    @if(hasPermission('parcel_status_update') == true)
                                    <td>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend be-addon">
                                                <button tabindex="-1" data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"><span class="sr-only">Toggle Dropdown</span></button>
                                                <div class="dropdown-menu">
                                                     {!! parcelStatus($parcel)  !!}
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>

                        </table>


                        @include('backend.parcel.pickup_assign_modal')
                        @include('backend.parcel.pickup_re_schedule')
                        @include('backend.parcel.received_by_pickup')
                        @include('backend.parcel.transfer_to_hub')
                        @include('backend.parcel.received_by_hub')
                        @include('backend.parcel.delivery_man_assign')
                        @include('backend.parcel.delivery_reschedule')
                        @include('backend.parcel.partial_delivered_modal')
                        @include('backend.parcel.delivered_modal')
                        @include('backend.parcel.received_warehouse')
                        @include('backend.parcel.return_to_qourier')
                        @include('backend.parcel.return_assign_to_merchant')
                        @include('backend.parcel.re_schedule_return_assign_to_merchant')
                        @include('backend.parcel.return_received_by_merchant')
                        @include('backend.parcel.transfer_to_hub_multiple_parcel')
                        @include('backend.parcel.received_by_hub_multiple_parcel')
                        @include('backend.parcel.assign_pickup_bulk')
                        @include('backend.parcel.delivery_man_assign_multiple_parcel')
                        @include('backend.parcel.assign_return_to_merchant_bulk')

                    </div>
                </div>
                <div class="col-12">
                    <div class="table-responsive">
                        <span>{{ $parcels->links() }}</span>
                        <p class="p-2 small">
                            {!! __('Showing') !!}
                            <span class="font-medium">{{ $parcels->firstItem() }}</span>
                            {!! __('to') !!}
                            <span class="font-medium">{{ $parcels->lastItem() }}</span>
                            {!! __('of') !!}
                            <span class="font-medium">{{ $parcels->total() }}</span>
                            {!! __('results') !!}
                        </p>
                    </div>
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
    #selectAssignType .select2-container .select2-selection--single {
    height: 32px !important;
}
</style>

@endpush
<!-- js  -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="{{ asset('backend/js/date-range-picker/date-range-picker-custom.js') }}"></script>
<script>
    var merchantUrl = '{{ route('parcel.merchant.get') }}';
    var merchantID = '{{ $request->parcel_merchant_id }}';
    var deliveryManID = '{{ $request->parcel_deliveryman_id }}';
    var pickupManID = '{{ $request->parcel_pickupman_id }}';
    var dateParcel = '{{ $request->parcel_date }}';
</script>
<script src="{{ asset('backend/js/parcel/custom.js') }}"></script>
<script src="{{ asset('backend/js/parcel/filter.js') }}"></script>
<script src="{{ asset('backend/js/parcel/parcel-search.js') }}"></script>

 @endpush
