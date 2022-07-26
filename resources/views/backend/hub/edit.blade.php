@extends('backend.partials.master')
@section('title','Hub | Edit')
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
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{__('levels.dashboard')}}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('hubs.index') }}" class="breadcrumb-link">{{__('hub.title')}}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{__('levels.edit')}}</a></li>
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
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="pageheader-title">{{__('hub.edit_hub')}}</h2>
                    <form action="{{route('hubs.update',['id'=>$hub->id])}}"  method="POST" enctype="multipart/form-data" id="basicform">
                        @csrf
                        @if (isset($hub))
                            @method('PUT')
                        @endif
                        <div class="form-group">
                            <label for="name">{{__('levels.name')}}</label> <span class="text-danger">*</span>
                            <input id="name" type="text" name="name" data-parsley-trigger="change" placeholder="{{ __('placeholder.Enter_name') }}" autocomplete="off" class="form-control @error('name') is-invalid @enderror" value="{{$hub->name}}" require>
                            @error('name')
                                <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">{{__('levels.phone')}}</label> <span class="text-danger">*</span>
                            <input id="phone" type="number" name="phone" data-parsley-trigger="change" placeholder="{{ __('placeholder.Enter_phone') }}" autocomplete="off" class="form-control @error('phone') is-invalid @enderror" value="{{$hub->phone}}" require>
                            @error('phone')
                                <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">{{__('levels.address')}}</label> <span class="text-danger">*</span>
                            <input id="address" type="text" name="address" data-parsley-trigger="change" placeholder="{{ __('placeholder.Enter_address') }}" autocomplete="off" class="form-control @error('address') is-invalid @enderror" value="{{$hub->address}}" require>
                            @error('address')
                                <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">{{ __('levels.status') }}</label> <span class="text-danger">*</span>
                            <select name="status" class="form-control @error('status') is-invalid @enderror">
                                @foreach(trans('status') as $key => $status)
                                    <option value="{{ $key }}" {{ (old('status',$hub->status) == $key) ? 'selected' : '' }}>{{ $status }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 ">
                                <button type="submit" class="btn btn-space btn-primary">{{__('levels.update')}}</button>
                                <a href="{{ route('hubs.index') }}" class="btn btn-space btn-secondary">{{__('levels.cancel')}}</a>
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

