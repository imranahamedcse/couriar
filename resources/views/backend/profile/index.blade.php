@extends('backend.partials.master')
@section('title','User | Profile')
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
                            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}" class="breadcrumb-link">{{ __('menus.dashboard') }}</a></li>
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
                            <a href="{{route('profile.edit',$user->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-edit" aria-hidden="true"></i> {{ __('levels.edit') }}</a>
                        </div>
                    </div>
                    <div class="row px-3">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm">
                                <tr>
                                    <td rowspan="10" class="align-middle text-center">
                                        <img src="{{asset($user->image)}}" alt="user" class="rounded-circle" width="100" height="100">
                                        <br>
                                        <br>
                                        <strong>{{$user->name}}</strong>
                                        <p>{{$user->email}}</p>
                                    </td>
                                    <td>{{ __('levels.name') }}</td>
                                    <td>{{$user->name}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('levels.email') }}</td>
                                    <td>{{$user->email}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('levels.mobile') }}</td>
                                    <td>{{$user->mobile}}</td>
                                </tr>
                                @if(Auth::user()->id != 1)
                                <tr>
                                    <td>{{ __('levels.nid') }} {{ __('levels.number') }}</td>
                                    <td>{{$user->nid_number}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('levels.designation') }}</td>
                                    <td>{{$user->designation->title}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('levels.department') }}</td>
                                    <td>{{$user->department->title}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('levels.hub') }}</td>
                                    <td>{{$user->hub->name}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('levels.joining_date') }}</td>
                                    <td>{{$user->joining_date}}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td>{{ __('levels.address') }}</td>
                                    <td>{{$user->address}}</td>
                                </tr>
                                <tr>
                                    <td>{{ __('levels.status') }}</td>
                                    <td>
                                        @if($user->status == 1)
                                            <span class="badge badge-pill badge-success">{{ __('levels.active') }}</span>
                                        @else
                                            <span class="badge badge-pill badge-danger">{{ __('levels.inactive') }}</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- {{$user}} -->
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

