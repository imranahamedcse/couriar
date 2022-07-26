@extends('backend.partials.master')
@section('title','DeliveryMan | Edit')
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
                            <li class="breadcrumb-item"><a href="{{ route('deliveryman.index') }}" class="breadcrumb-link">{{ __('deliveryman.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ __('levels.edit') }}</a></li>
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
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">

                    <h2 class="pageheader-title">{{ __('deliveryman.edit_deliveryman') }}</h2>
                    <form action="{{route('deliveryman.update',['id'=>$deliveryman->id])}}"  method="POST" enctype="multipart/form-data" id="basicform">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="Name">{{ __('levels.name') }}</label> <span class="text-danger">*</span>
                                    <input id="name" type="text" name="name" data-parsley-trigger="change" placeholder="{{ __('placeholder.Enter_name') }}" autocomplete="off" class="form-control @error('name') is-invalid @enderror" value="{{old('name',$deliveryman->user->name)}}" require>
                                    @error('name')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">{{ __('levels.email') }}</label> <span class="text-danger">*</span>
                                    <input id="email" type="text" name="email" data-parsley-trigger="change" placeholder="{{ __('placeholder.enter_email') }}" autocomplete="off" class="form-control @error('email') is-invalid @enderror" value="{{old('email',$deliveryman->user->email)}}">
                                    @error('email')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="return_charge">{{ __('levels.return_charge') }}</label>
                                    <input id="return_charge" type="number" step="any" name="return_charge" data-parsley-trigger="change" placeholder="{{ __('placeholder.Enter_return_charge') }}" autocomplete="off" class="form-control @error('return_charge') is-invalid @enderror" value="{{old('return_charge',$deliveryman->return_charge)}}">
                                    @error('return_charge')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="opening_balance">{{ __('levels.opening_balance') }}</label>
                                    <input id="opening_balance" type="number" step="any" name="opening_balance" data-parsley-trigger="change" placeholder="{{ __('placeholder.Enter_opening_balance') }}" autocomplete="off" class="form-control @error('opening_balance') is-invalid @enderror" value="{{old('opening_balance',$deliveryman->opening_balance)}}">
                                    @error('opening_balance')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group pt-1">
                                    <label for="input-select">{{ __('levels.salary') }}</label>
                                    <input type="text" class="form-control" placeholder="{{ __('salary.title') }}" name="salary" value="{{ $deliveryman->user->salary }}" />
                                    @error('salary')
                                        <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div >

                                <div class="form-group">
                                    <label for="current_balance">{{ __('levels.current_balance') }}</label>
                                    <input id="current_balance" type="number" step="any" name="current_balance" data-parsley-trigger="change" placeholder="{{ __('placeholder.Enter_opening_balance') }}" autocomplete="off" class="form-control @error('current_balance') is-invalid @enderror" value="{{old('current_balance',$deliveryman->current_balance)}}">
                                    @error('current_balance')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="input-select">{{ __('levels.hub') }}</label> <span class="text-danger">*</span>
                                    <select class="form-control @error('hub_id') is-invalid @enderror" id="input-select" name="hub_id"  required>
                                        @foreach($hubs as $hub)
                                            <option value="{{$hub->id}}" {{ (old('hub_id',$deliveryman->user->hub_id) == $hub->id) ? 'selected' : '' }}>{{$hub->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('hub')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-9">
                                            <label for="image_id">{{ __('levels.image')}}</label>
                                            <input id="image_id" type="file" name="image_id" data-parsley-trigger="change" autocomplete="off" class="form-control"  require>
                                        </div>
                                        <div class="col-3">
                                            <img src="{{asset($deliveryman->user->image)}}" alt="user" class="rounded"  width="75" height="75">
                                        </div>
                                    </div>

                                    @error('image_id')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="address" class="col-form-label text-sm-right">{{ __('levels.address') }}</label>  <span class="text-danger">*</span>
                                    <textarea name="address" placeholder="{{ __('placeholder.Enter_address') }}" id="address" class="form-control @error('address') is-invalid @enderror">{{ old('address',$deliveryman->user->address) }}</textarea>
                                    @error('address')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="mobile">{{ __('levels.phone') }}</label> <span class="text-danger">*</span>
                                    <input id="mobile" type="number" step="any" name="mobile" data-parsley-trigger="change" placeholder="{{ __('placeholder.Enter_phone') }}" autocomplete="off" class="form-control @error('mobile') is-invalid @enderror" value="{{old('mobile',$deliveryman->user->mobile)}}">
                                    @error('mobile')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="delivery_charge">{{ __('levels.delivery_charge') }}</label>
                                    <input id="delivery_charge" type="number" step="any" name="delivery_charge" data-parsley-trigger="change" placeholder="{{ __('placeholder.Enter_delivery_charge') }}" autocomplete="off" class="form-control @error('delivery_charge') is-invalid @enderror" value="{{old('delivery_charge',$deliveryman->delivery_charge)}}">
                                    @error('delivery_charge')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="pickup_charge">{{ __('levels.pickup_charge') }}</label>
                                    <input id="pickup_charge" type="number" step="any" name="pickup_charge" data-parsley-trigger="change" placeholder="{{ __('placeholder.Enter_pickup_charge') }}" autocomplete="off" class="form-control @error('pickup_charge') is-invalid @enderror" value="{{old('pickup_charge',$deliveryman->pickup_charge)}}">
                                    @error('pickup_charge')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">{{ __('levels.password') }}</label>
                                    <input id="password" type="password" name="password" data-parsley-trigger="change" placeholder="{{ __('placeholder.Enter_password') }}" autocomplete="off" class="form-control @error('password') is-invalid @enderror" value="{{old('password')}}">
                                    @error('password')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="status">{{ __('levels.status') }}</label> <span class="text-danger">*</span>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        @foreach(trans('status') as $key => $status)
                                            <option value="{{ $key }}" {{ (old('status',$deliveryman->user->status) == $key) ? 'selected' : '' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-9">
                                            <label for="driving_license_image_id">{{ __('levels.driving_license') }}</label>
                                            <input id="driving_license_image_id" type="file" name="driving_license_image_id" data-parsley-trigger="change" autocomplete="off" class="form-control" value="{{ old('driving_license_image_id') }}" require>
                                        </div>
                                        <div class="col-3">
                                            <img src="{{asset($deliveryman->driving_license_image)}}" alt="user" class="rounded"  width="75" height="75">
                                        </div>
                                    </div>

                                    @error('driving_license_image_id')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                <button type="submit" class="btn btn-space btn-primary">{{ __('levels.update') }}</button>
                                <a href="{{ route('deliveryman.index') }}" class="btn btn-space btn-secondary">{{ __('levels.cancel') }}</a>
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
<!-- ============================================================== -->
<!-- end wrapper  -->
<!-- ============================================================== -->
@endsection();



@push('styles')
    <!--  -->
@endpush

@push('scripts')
    <!--  -->
@endpush

