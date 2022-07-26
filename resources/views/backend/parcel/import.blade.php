@extends('backend.partials.master')
@section('title','Parcels  | Import')
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
                            <li class="breadcrumb-item"><a href="{{ route('parcel.index') }}" class="breadcrumb-link">{{ __('parcel.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link active">{{ __('parcel.import') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="row pl-4 pr-4 pt-4">
                    <div class="col-10">
                        <p class="h3">{{ __('parcel.title') }} {{ __('parcel.import') }}</p>
                    </div>
                    <div class="col-2">
                        <a href="{{asset('sample-parcel/parcel/import-parcel.xlsx')}}" download class="btn btn-success btn-sm float-right" data-toggle="tooltip" data-placement="top" title="download">{{ __('parcel.sample') }}</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-10 mb-5">
                                <p>Please check this before importing your file</p>
                                <ul class="list list-sm list-success">
                                    <li>Uploaded File type must be xlsx</li>
                                    <li>The file must contain pickup_address, pickup_phone,
                                        cash_collection, selling_price, customer_name, invoice_no, customer_phone, customer_address.</li>
                                    <li>Category: @foreach($deliveryCategories as $category) @if($loop->last){{ $category->id }}={{ $category->title }} @else {{ $category->id }}={{ $category->title }},@endif  @endforeach</li>
                                    <li>DeliverType: @foreach(trans('deliveryType') as $key => $status) @if($loop->last){{ $key }}={{ $status }} @else {{ $key}}={{ $status }},@endif  @endforeach</li>
                                    <li>cash_collection=0.00 and selling_price=0.00 must be numeric.</li>
                                    <li>
                                        <div class="form-group">
                                            <label for="merchant_id">{{ __('merchant.title') }}</label>:
                                            <select id="merchant_id" class="form-control @error('merchant_id') is-invalid @enderror">
                                                <option value=""> {{ __('Check Merchant ID') }}</option>

                                            </select>
                                            @error('merchant_id')
                                            <small class="text-danger mt-2">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <form action="{{ route('parcel.file-import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <div class="custom-file text-left">
                                                <input type="file" name="file" class="custom-file-input file-upload-input" id="customFile">
                                                <label class="custom-file-label" for="customFile">{{__('parcel.browse_file')}}</label>
                                            </div>
                                            @error('file')
                                            <div class="text-danger ">{{ $message }}</div>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control float-right">{{ __('parcel.import') }}</button>
                                    </div>

                                </div>
                            </form>
                        </div>

                        <div class="col-md-4">
                            @if(session()->has('importErrors'))
                                <h2 class="text-center border-bottom">{{__('parcel.validation_log')}}</h2>
                                @foreach(session()->get('importErrors') as $key => $values)
                                    <div class="text-primary ">{{__('parcel.in_row_number')}} : {{ $key }}</div>
                                    @foreach($values as $value)
                                        <div class="text-danger ">{{ $value }}</div>
                                    @endforeach
                                @endforeach

                            @endif
                        </div>
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
    <!--  -->

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function(){

            $( "#merchant_id" ).select2({
                ajax: {
                    url: '{{ route('parcel.import.merchant.get') }}',
                    type: "POST",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term,
                            searchQuery: true
                        };
                    },
                    processResults: function (response) {
                        console.log(response);
                        return {
                            results: response
                        };
                    },
                    cache: true
                }

            });

        });
    </script>
    <script src="{{ asset('backend/js/custom.js') }}"></script>
@endpush


