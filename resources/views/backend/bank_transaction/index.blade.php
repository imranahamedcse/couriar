@extends('backend.partials.master')
@section('title','Bank Transaction | List')
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
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">{{ __('account.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('bank-transaction.index') }}" class="breadcrumb-link">{{ __('menus.bank_transaction') }}</a></li>
                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link active">{{ __('levels.list') }}</a></li>
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
                    <form action="{{route('bank-transaction.filter')}}"  method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-12 col-md-3">
                                <label for="date">{{ __('parcel.date') }}</label>
                                <input type="text" autocomplete="off" id="date" name="date" class="form-control date_range_picker p-2" value="{{ isset($request->date) ? $request->date : old('date') }}" placeholder="Enter date">

                                @error('date')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-3">
                                <label for="type">{{ __('levels.type') }}</label>
                                <select name="type" class="form-control @error('type') is-invalid @enderror">
                                    <option value="" selected>Select Type</option>
                                    @foreach(\config('rxcourier.account_heads_type') as $key => $value)
                                        <option value="{{ $value }}" {{ (isset($request->type) ? $request->type : old('type')) == $value ? 'selected' : '' }}>{{ __('AccountHeads.'.$value)}}</option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-3">
                                <label for="account">{{ __('levels.account') }}</label>
                                <select name="account" class="form-control @error('account') is-invalid @enderror">
                                    <option value="" selected>Select Account</option>
                                    @foreach ($accounts as $account)
                                        @if ($account->type == App\Enums\AccountType::ADMIN)
                                            <option value="{{$account->id}}" {{ ((isset($request->account) ? $request->account : old('account')) == $account->id) ? 'selected' : '' }}>{{$account->account_no}} ({{$account->account_holder_name}})</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('account')
                                    <small class="text-danger mt-2">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group col-12 col-md-3 pt-1">
                                <div class="text-right pt-4">
                                    <button type="submit" class="btn btn-space btn-primary"><i class="fa fa-filter"></i> {{ __('levels.filter') }}</button>
                                    <a href="{{ route('bank-transaction.index') }}" class="btn btn-space btn-secondary"><i class="fa fa-eraser"></i> {{ __('levels.clear') }}</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="row pl-4 pr-4 pt-4">
                    <div class="col-12">
                        <p class="h3">{{ __('menus.bank_transaction') }}</p>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>{{ __('###') }}</th>
                                    <th>{{ __('levels.account_no') }} | {{__('levels.name')}}</th>
                                    <th>{{ __('levels.type') }}</th>
                                    <th>{{ __('levels.amount') }}</th>
                                    <th>{{ __('levels.date') }}</th>
                                    <th>{{ __('levels.note') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $n = 0;
                                @endphp
                                @foreach ($transactions as $transaction)
                                    <tr>
                                        <td>{{++$n}}</td>

                                        <td>
                                            @if($transaction->account->gateway == 1)
                                                {{@$transaction->account->user->name}} (Cash)
                                            @else
                                                @if($transaction->account->gateway == 3)
                                                    bKash ,
                                                @elseif ($transaction->account->gateway == 4)
                                                    Rocket ,
                                                @elseif ($transaction->account->gateway == 5)
                                                    Nagad ,
                                                @endif
                                                {{$transaction->account->account_holder_name}}
                                                ({{$transaction->account->account_no}}
                                                {{$transaction->account->branch_name}}
                                                {{$transaction->account->mobile}})
                                            @endif
                                        </td>
                                        <td>{!! $transaction->account_type !!}</td>
                                        <td>{{settings()->currency}}{{$transaction->amount}}</td>
                                        <td>{{dateFormat($transaction->date)}}</td>
                                        <td>{{$transaction->note}}</td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>

                    </div>
                </div>
                <div class="col-12">
                    <div class="table-responsive">
                        <span>{{ $transactions->links() }}</span>
                        <p class="p-2 small">
                            {!! __('Showing') !!}
                            <span class="font-medium">{{ $transactions->firstItem() }}</span>
                            {!! __('to') !!}
                            <span class="font-medium">{{ $transactions->lastItem() }}</span>
                            {!! __('of') !!}
                            <span class="font-medium">{{ $transactions->total() }}</span>
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
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush
<!-- js  -->
@push('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript" src="{{ asset('backend/js/date-range-picker/date-range-picker-custom.js') }}"></script>
 @endpush

