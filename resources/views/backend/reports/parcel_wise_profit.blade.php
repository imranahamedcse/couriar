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
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ __('menus.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ __('reports.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('parcel.reports') }}" class="breadcrumb-link">{{ __('reports.parcel_wise_profit') }}</a></li>

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
                <div class="card-body">
                    <form action="{{route('parcel.wise.profit.reports')}}"  method="GET">
                        @csrf
                        <div class="row">
                            <div class="form-group col-3">
                                <label for="parcel_date">{{ __('parcel.date') }}</label>
                                <input type="text" autocomplete="off" id="date" name="parcel_date" class="form-control date_range_picker" value="{{ old('parcel_date',$request->parcel_date) }}">

                                @error('parcel_date')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group col-3">
                                <label for="parcelMerchantid">{{ __('parcel.merchant') }}</label>
                                <select style="width: 100%" id="parcelMerchantid"  name="parcel_merchant_id" class="form-control @error('parcel_merchant_id') is-invalid @enderror" data-url="{{ route('parcel.merchant.shops') }}">
                                    <option value=""> {{ __('menus.select') }} {{ __('merchant.title') }}</option>

                                </select>
                                @error('parcel_merchant_id')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>



                            <div class="form-group col-3">
                                <label for="parcelhub">{{ __('parcel.hub') }}</label>
                                <select style="width: 100%" id="parcelhub"  name="hub_id" class="form-control  "  >
                                    <option value="" selected> {{ __('menus.select') }} {{ __('hub.title') }}</option>
                                    @foreach ($hubs as  $hub)
                                    <option value="{{ $hub->id }}" @if(old('hub_id',$hub->id) == $request->hub_id) selected @endif>{{ $hub->name }}</option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="form-group col-3">
                                <label for="parcel_profit">{{ __('reports.parcel_tracking_id') }}</label>
                                <select style="width: 100%" id="parcel_profit"   name="parcel_tracking_id[]" class="form-control @error('parcel_tracking_id') is-invalid @enderror" multiple="multiple" >
                                </select>
                                @error('parcel_tracking_id')
                                <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>



                            <div class="col-12">
                                <div class="form-group d-inline-block float-right pt-1">
                                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 pt-4 d-flex justify-content">
                                        <button type="submit" class="btn btn-space btn-primary"><i class="fa fa-filter"></i> {{ __('levels.filter') }}</button>
                                        <a href="{{ route('parcel.reports') }}" class="btn btn-space btn-secondary"><i class="fa fa-eraser"></i> {{ __('levels.clear') }}</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            @if(isset($print))




            <div class="card">
                <div class="card-header">
                    <div class="row px-4">
                        <div class="col-6">
                            <h3>{{ __('reports.parcel_wise_profit') }}</h3>
                        </div>
                        <div class="col-6 text-right">
                            <button type="button" id="exportTable" data-title="Parcel Wise Profit" data-filename="ParcelWiseProfit" class="btn btn-success">{{ __('menus.export') }}</button>
                            <a href="{{ route('parcel.wise.profit.print.page',$parcel_ids) }}" class="btn btn-primary" target="_blank">{{ __('reports.print') }}</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive" style="overflow-x:unset">
                        <table class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>{{ __('###') }}</th>
                                    <th>{{ __('reports.details') }}</th>
                                    <th>{{ __('reports.income') }}</th>
                                    <th>{{ __('reports.expense') }}</th>
                                    <th>{{ __('reports.profit') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp

                                    @foreach($parcels as $key=>$parcel)
                                    <tr>
                                        <td>
                                            {{ $i++ }}
                                        </td>
                                        <td>
                                           <b>Tracking Id :</b> <a class="active" href="{{ route('parcel.details',$parcel->id) }}" target="_blank">{{ $parcel->tracking_id }}</a><br/>
                                            <span><b>Merchant :</b>  {{$parcel->merchant->business_name}}</span><br>
                                            <span><b>Customer :</b>  {{$parcel->customer_name}}</span><br>

                                            <td> {{ settings()->currency }} {{ $parcel->total_delivery_amount }}</td>
                                        </td>
                                        <td> {{ settings()->currency }} {{ parcelExpense($parcel->id) }}</td>
                                        <td>{{ settings()->currency }} {{  ($parcel->total_delivery_amount - parcelExpense($parcel->id)) }}    </td>

                                    </tr>
                                    @endforeach


                                    <tr   class="totalCalculationHead bg-primary"  >
                                        <td ></td>
                                        <td class="">{{ __('reports.total') }}    : </td>
                                        <td> {{ settings()->currency }}  {{ $parcels->sum('total_delivery_amount') }} </td>
                                        <td> {{ settings()->currency }}  {{ parcelExpenseTotal($parcels->pluck('id')) }} </td>
                                        <td >  {{ settings()->currency }}  {{ ($parcels->sum('total_delivery_amount') - parcelExpenseTotal($parcels->pluck('id')) ) }}</td>
                                    </tr>


                            </tbody>

                        </table>

                    </div>
                </div>

            </div>
            @endif
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
{{-- <script src="{{ asset('backend/js/parcel/custom.js') }}"></script> --}}
<script src="{{ asset('backend/js/parcel/filter.js') }}"></script>

<script src="{{ asset('backend/js/reports/print.js') }}"></script>
<script src="{{ asset('backend/js/reports/jquery.table2excel.min.js') }}"></script>
<script src="{{ asset('backend/js/reports/reports.js') }}"></script>


 @endpush

