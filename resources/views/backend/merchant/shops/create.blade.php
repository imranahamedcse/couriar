@section('title','Merchant | Shop | Add')

@extends('backend.merchant.view')

@section('backend.merchant.layout.list')
  <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{url('/')}}" class="breadcrumb-link">{{ __('levels.dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ __('merchantmanage.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('merchant.index') }}" class="breadcrumb-link">{{ __('merchant.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{route('merchant.shops.index',$singleMerchant->id) }}" class="breadcrumb-link">{{ __('merchantshops.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ __('levels.create') }}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

  <div class="card">
      <div class="card-body">
          <h2 class="pageheader-title">{{ __('merchantshops.create_shops') }}</h2>
          <form action="{{route('merchant.shops.store')}}"  method="POST" enctype="multipart/form-data" id="basicform">
              @csrf
              <div class="row">
                  <div class="col-12">

                      <input type="hidden" name="merchant_id" value="{{ $merchant_id }}" />

                      <div class="form-group">
                          <label for="name">{{ __('levels.name') }}</label> <span class="text-danger">*</span>
                          <input id="name" type="text" name="name" data-parsley-trigger="change" placeholder="{{ __('placeholder.Enter_name') }}" autocomplete="off" class="form-control" value="{{old('name')}}" require>
                          @error('name')
                          <small class="text-danger mt-2">{{ $message }}</small>
                          @enderror
                      </div>


                      <div class="form-group">
                          <label for="contact">{{ __('merchantshops.contact') }}</label> <span class="text-danger">*</span>
                          <input id="contact" type="number" name="contact_no" data-parsley-trigger="change" placeholder="{{ __('placeholder.Enter_contact_no') }}" autocomplete="off" class="form-control" value="{{old('contact_no')}}" require>
                          @error('contact_no')
                          <small class="text-danger mt-2">{{ $message }}</small>
                          @enderror
                      </div>


                      <div class="form-group">
                          <label for="address">{{ __('merchantshops.address') }}</label> <span class="text-danger">*</span>
                          <textarea id="address" placeholder="{{ __('placeholder.Enter_address') }}" name="address" class="form-control">{{ old('address') }}</textarea>
                          @error('address')
                          <small class="text-danger mt-2">{{ $message }}</small>
                          @enderror
                      </div>

                      <div class="form-group">
                          <label for="status">{{__('levels.status')}}</label> <span class="text-danger">*</span>
                          <select name="status" class="form-control @error('status') is-invalid @enderror">
                              @foreach(trans('status') as $key => $status)
                                  <option value="{{ $key }}" {{ (old('status',\App\Enums\Status::ACTIVE) == $key) ? 'selected' : '' }}>{{ $status }}</option>
                              @endforeach
                          </select>
                          @error('status')
                          <small class="text-danger mt-2">{{ $message }}</small>
                          @enderror
                      </div>

                  </div>
              </div>
              <div class="row">
                  <div class="col-12">
                      <div class="form-group">
                          <button type="submit" class="btn btn-space btn-primary">{{ __('levels.submit') }}</button>
                          <a href="{{ route('merchant.view',$merchant_id) }}" class="btn btn-space btn-secondary">{{ __('levels.cancel') }}</a>
                      </div>
                  </div>
          </form>
      </div>
  </div>

@endsection();



@push('styles')
    <!--  -->
@endpush

@push('scripts')
    <!--  -->
@endpush

