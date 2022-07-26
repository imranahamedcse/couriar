@extends('backend.partials.master')
@section('title','Merchant | Profile')
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
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ __('dashboard.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ __('menus.profile') }}</a></li>
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
                    <div class="d-flex justify-content-between align-items-center pb-2">
                        <div>
                            <h2 class="pageheader-title">{{ __('user.title') }} {{ __('menus.profile') }}</h2>
                        </div>
                        <div>
                            <a href="{{route('merchant-profile.edit',$merchat->user->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-edit" aria-hidden="true"></i> {{ __('levels.edit') }}</a>
                        </div>
                    </div>
                    <div class="row px-3">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm">
                                <tr>
                                    <td rowspan="12" class="align-middle text-center">
                                        <img src="{{asset($merchat->user->image)}}" alt="user" class="rounded-circle" width="100" height="100">
                                        <br>
                                        <br>
                                        <strong>{{$merchat->user->name}}</strong>
                                        <p>{{$merchat->user->email}}</p>
                                    </td>
                                    <td>{{ __('levels.name') }}</td>
                                    <td>{{$merchat->user->name}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('levels.address') }}</td>
                                    <td>{{$merchat->user->email}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('levels.mobile') }}</td>
                                    <td>{{$merchat->user->mobile}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('levels.business_name') }}</td>
                                    <td>{{$merchat->business_name}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('levels.merchant_unique_id') }}</td>
                                    <td>{{$merchat->merchant_unique_id}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('levels.opening_balance') }}</td>
                                    <td>{{$merchat->opening_balance}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('levels.vat') }}</td>
                                    <td>{{$merchat->vat}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('levels.status') }}</td>
                                    <td>
                                        @if($merchat->status == \App\Enums\Status::ACTIVE)
                                            <span class="badge badge-pill badge-success">{{ __('levels.active') }}</span>
                                        @else
                                            <span class="badge badge-pill badge-danger">{{ __('levels.inactive') }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('levels.address') }}</td>
                                    <td>{{$merchat->address}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('levels.nid') }}</td>
                                    <td>
                                        <img src="{{asset($merchat->nid)}}" alt="user" class="rounded" height="65" width="100">
                                    </td>
                                </tr>
                                <tr>
                                    <td>{{ __('levels.trade_license') }}</td>
                                    <td>
                                        <img src="{{asset($merchat->trade)}}" alt="user" class="rounded" height="65" width="100">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
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

