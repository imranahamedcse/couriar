@extends('backend.partials.master')
@section('title','Merchant | Add')



@section('maincontent')
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
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ __('merchantmanage.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('merchant.index') }}" class="breadcrumb-link">{{ __('merchant.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ __('levels.create') }}</a></li>
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
        <!-- basic form -->
        <!-- ============================================================== -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="pageheader-title">{{ __('merchant.create_merchant') }}</h2>
                    <form action="{{route('merchant.store')}}"  method="POST" enctype="multipart/form-data" id="basicform">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <input id="merchant_unique_id" type="hidden" name="merchant_unique_id" data-parsley-trigger="change" class="form-control">
                                <div class="form-group">
                                    <label for="business_name">{{ __('levels.business_name') }}</label> <span class="text-danger">*</span>
                                    <input id="business_name" type="text" name="business_name" data-parsley-trigger="change" placeholder="{{ __('placeholder.enter_business_name') }}" autocomplete="off" class="form-control" value="{{old('business_name')}}" require>
                                    @error('business_name')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group ">
                                    <label for="email">{{ __('levels.email') }}</label>
                                    <input id="email" type="text" name="email" data-parsley-trigger="change" placeholder="{{ __('placeholder.enter_email') }}" autocomplete="off" class="form-control" value="{{old('email')}}">
                                    @error('email')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="opening_balance">{{ __('levels.opening_balance') }}</label>
                                    <input id="opening_balance" type="number" name="opening_balance" data-parsley-trigger="change" placeholder="{{ __('placeholder.Enter_opening_balance') }}" autocomplete="off" class="form-control" value="{{old('opening_balance')}}">
                                    @error('opening_balance')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="opening_balance">{{ __('levels.vat') }}</label>
                                    <input id="vat" type="number" name="vat" data-parsley-trigger="change" placeholder="{{ __('placeholder.Enter_vat') }}" autocomplete="off" class="form-control" value="{{old('vat')}}">
                                    @error('vat')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="image">{{ __('levels.nid') }}</label>
                                    <input id="nid" type="file" name="nid" data-parsley-trigger="change" autocomplete="off" class="form-control" value="{{ old('nid') }}" require>

                                    @error('nid')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="image">{{ __('levels.trade_license') }}</label>
                                    <input id="trade_license" type="file" name="trade_license" data-parsley-trigger="change" autocomplete="off" class="form-control" value="{{ old('trade_license') }}" require>

                                    @error('trade_license')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="Name">{{ __('levels.name') }}</label> <span class="text-danger">*</span>
                                    <input id="name" type="text" name="name" data-parsley-trigger="change" placeholder="{{ __('placeholder.Enter_name') }}" autocomplete="off" class="form-control" value="{{old('name')}}" require>
                                    @error('name')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="phone">{{ __('levels.phone') }}</label> <span class="text-danger">*</span>
                                    <input id="mobile" type="number" name="mobile" data-parsley-trigger="change" placeholder="{{ __('placeholder.Enter_mobile') }}" autocomplete="off" class="form-control" value="{{old('mobile')}}">
                                    @error('mobile')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">{{ __('levels.password') }}</label> <span class="text-danger">*</span>
                                    <input id="password" type="password" name="password" data-parsley-trigger="change" placeholder="{{ __('placeholder.Enter_password') }}" autocomplete="off" class="form-control" value="{{old('password')}}">
                                    @error('password')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>


                                <div class="form-group">
                                    <label for="hub">{{ __('levels.hub') }} <span class="text-danger">*</span></label>
                                    <select class="form-control p-1" id="hub" name="hub" value="{{ old('hub') }}" required>
                                        <option disabled selected>{{ __('menus.select') }} {{ __('hub.title') }}</option>
                                        @foreach($hubs as $hub)
                                            <option {{ old('hub') == $hub->id ? 'selected' : '' }} value="{{ $hub->id }}">{{$hub->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('hub')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="status">{{ __('levels.status') }}</label>
                                    <select class="form-control p-1" id="status" name="status" value="{{ old('status') }}" required>
                                        <option value="1" selected>{{ __('levels.active') }}</option>
                                        <option value="0">{{ __('levels.inactive') }}</option>
                                    </select>
                                    @error('status')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="image">{{ __('levels.image') }}</label>
                                    <input id="image_id" type="file" name="image_id" data-parsley-trigger="change" autocomplete="off" class="form-control" value="{{ old('image_id') }}" require>

                                    @error('image_id')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group pt-2 ">
                                    <label for="address">{{ __('levels.address') }}</label>  <span class="text-danger">*</span>
                                    <textarea id="address" placeholder="{{ __('placeholder.Enter_address') }}" name="address" class="form-control">{{old('address')}}</textarea>
                                    @error('address')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <h2 for="input-select">{{ __('levels.cod_charge') }}</h2>
                                    <div class="row">
                                        @foreach(\Config::get('rxcourier.cod_charges') as $key=>$charge)
                                        <input type="hidden" value="{{$key}}" name="area[]">
                                        <div class="col-12 col-md-4">
                                            <label class="select-input">{{str_replace('_', ' ',  ucwords($key))}}</label>
                                            <input type="number" name="charge[{{$key}}]" autocomplete="off" class="form-control" value="{{ old('charge.'.$key,$charge)}}" placeholder="charge">
                                            <!-- @error('')
                                                <small class="text-danger mt-2">{{ $message }}</small>
                                            @enderror -->
                                        </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                <button type="submit" class="btn btn-space btn-primary">{{ __('levels.submit') }}</button>
                                <a href="{{ route('merchant.index') }}" class="btn btn-space btn-secondary">{{ __('levels.cancel') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end basic form -->
        <!-- ============================================================== -->

    </div>

</div>
@endsection();



@push('styles')
    <!--  -->
@endpush

@push('scripts')
    <!--  -->
@endpush

