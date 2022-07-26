@extends('backend.partials.master')
@section('title','Role | Add')


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
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{__('menus.user_role')}}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('roles.index') }}" class="breadcrumb-link">{{ __('role.title') }}</a></li>
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
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <h2 class="pageheader-title">{{ __('role.create_role') }}</h2>

                    <form action="{{route('roles.store')}}"  method="POST" enctype="multipart/form-data" id="basicform">
                        @csrf

                        <div class="row">
                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">

                                    <div class="form-group">
                                        <label for="name">{{ __('levels.name') }}</label> <span class="text-danger">*</span>
                                        <input id="name" type="text" name="name" data-parsley-trigger="change" placeholder="{{ __('placeholder.Enter_name') }}"  autocomplete="off" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" require>
                                        @error('name')
                                            <small class="text-danger mt-2">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="status">{{ __('levels.status') }}</label>
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
                                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                                    <div class="">
                                        <table class="table table-striped" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('permissions.modules') }}</th>
                                                    <th>{{ __('permissions.permissions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($permissions as $permission )
                                                    <tr>
                                                        <td>{{__('permissions.'.$permission->attribute) }}</td>
                                                        <td>
                                                            @foreach ($permission->keywords as $key=>$keyword)
                                                                <div class="row align-items-center permission-check-box pb-2 pt-2"  >
                                                                    <input id="{{ $keyword }}" class="read common-key" type="checkbox" value="{{ $keyword }}" name="permissions[]"  />
                                                                    <label for="{{ $keyword }}">{{ __('permissions.'.$key) }}</label>
                                                                </div>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endforeach


                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-right ">
                                <button type="submit" class="btn btn-space btn-primary">{{ __('levels.submit') }}</button>
                                <a href="{{ route('roles.index') }}" class="btn btn-space btn-secondary">{{ __('levels.cancel') }}</a>
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

@endpush

@push('scripts')
    <script src="{{ asset('backend/js/roles/roles.js') }}"></script>
@endpush

