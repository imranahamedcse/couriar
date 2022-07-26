@extends('backend.partials.master')
@section('title','Fund Transfer | List')
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
                            <li class="breadcrumb-item"><a href="{{route('fund-transfer.index')}}" class="breadcrumb-link">{{ __('fund_transfer.title') }}</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">{{ __('levels.list') }}</a></li>
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
                <div class="row pl-4 pr-4 pt-4">
                    <div class="col-10">
                        <p class="h3">{{ __('fund_transfer.title') }}</p>
                    </div>
                    @if(hasPermission('fund_transfer_create') )
                    <div class="col-2">
                        <a href="{{route('fund-transfer.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="top" title="{{ __('levels.add') }}"><i class="fa fa-plus"></i></a>
                    </div>
                    @endif
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>{{ __('levels.id') }}</th>
                                    <th>{{ __('levels.from_account') }}</th>
                                    <th>{{ __('levels.to_account') }}</th>
                                    <th>{{ __('levels.date') }}</th>
                                    <th>{{ __('levels.amount') }}</th>
                                    @if(hasPermission('fund_transfer_update') == true || hasPermission('fund_transfer_delete') == true )
                                    <th>{{ __('levels.actions') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach($fund_transfers as $fund_transfer)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-4">
                                                <img src="{{$fund_transfer->fromAccount->user->image}}" alt="Image" class="rounded" width="40" height="40">
                                            </div>
                                            <div class="col-8">
                                                <strong> {{$fund_transfer->fromAccount->user->name}}</strong><br>
                                                <span> {{$fund_transfer->fromAccount->user->email}}</span><br>
                                            </div>
                                        </div>
                                        @if ($fund_transfer->fromAccount->gateway == 2)
                                        {{-- Bank info --}}
                                            <div class="row">
                                                <div class="col-4">{{__('levels.bank')}}</div>
                                                <div class="col-8">:
                                                    @if ($fund_transfer->fromAccount->bank == 1)
                                                        BB
                                                    @elseif($fund_transfer->fromAccount->bank == 2)
                                                        DBBL
                                                    @elseif($fund_transfer->fromAccount->bank == 3)
                                                        IB
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">{{__('levels.branch_name')}}</div>
                                                <div class="col-8">: {{$fund_transfer->fromAccount->branch_name}}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">{{__('levels.account_no')}}</div>
                                                <div class="col-8">: {{$fund_transfer->fromAccount->account_no}}</div>
                                            </div>
                                        @elseif ($fund_transfer->fromAccount->gateway == 3)
                                        {{-- Mobile bank info --}}
                                            <div class="row">
                                                <div class="col-4">{{__('levels.mobile')}}</div>
                                                <div class="col-8">: {{$fund_transfer->fromAccount->mobile}}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">{{__('levels.type')}}</div>
                                                <div class="col-8">:
                                                    @if ($fund_transfer->fromAccount->account_type == 1)
                                                        Merchant
                                                    @else
                                                        Personal
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-4">{{__('levels.balance')}}</div>
                                            <div class="col-8">: {{settings()->currency}}{{$fund_transfer->fromAccount->balance}}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">{{__('levels.opening_balance')}}</div>
                                            <div class="col-8">: {{settings()->currency}}{{$fund_transfer->fromAccount->opening_balance}}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-4">
                                                <img src="{{$fund_transfer->toAccount->user->image}}" alt="Image" class="rounded" width="40" height="40">
                                            </div>
                                            <div class="col-8">
                                                <strong> {{$fund_transfer->toAccount->user->name}}</strong><br>
                                                <span> {{$fund_transfer->toAccount->user->email}}</span><br>
                                            </div>
                                        </div>
                                        @if ($fund_transfer->toAccount->gateway == 2)
                                        {{-- Bank info --}}
                                            <div class="row">
                                                <div class="col-4">{{__('levels.bank')}}</div>
                                                <div class="col-8">:
                                                    @if ($fund_transfer->toAccount->bank == 1)
                                                        BB
                                                    @elseif($fund_transfer->toAccount->bank == 2)
                                                        DBBL
                                                    @elseif($fund_transfer->toAccount->bank == 3)
                                                        IB
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">{{__('levels.branch_name')}}</div>
                                                <div class="col-8">: {{$fund_transfer->toAccount->branch_name}}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">{{__('levels.account_no')}}</div>
                                                <div class="col-8">: {{$fund_transfer->toAccount->account_no}}</div>
                                            </div>
                                        @elseif ($fund_transfer->toAccount->gateway == 3)
                                        {{-- Mobile bank info --}}
                                            <div class="row">
                                                <div class="col-4">{{__('levels.mobile')}}</div>
                                                <div class="col-8">: {{$fund_transfer->toAccount->mobile}}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">{{__('levels.type')}}</div>
                                                <div class="col-8">:
                                                    @if ($fund_transfer->toAccount->account_type == 1)
                                                        Merchant
                                                    @else
                                                        Personal
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row">
                                            <div class="col-4">{{__('levels.balance')}}</div>
                                            <div class="col-8">: {{settings()->currency}}{{$fund_transfer->toAccount->balance}}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">{{__('levels.opening_balance')}}</div>
                                            <div class="col-8">: {{settings()->currency}}{{$fund_transfer->toAccount->opening_balance}}</div>
                                        </div>
                                    </td>
                                    <td>{{dateFormat($fund_transfer->date)}}</td>
                                    <td>{{settings()->currency}}{{$fund_transfer->amount}}</td>
                                    @if(hasPermission('fund_transfer_update') == true || hasPermission('fund_transfer_delete') == true )
                                    <td>
                                        <div class="row">
                                            <button tabindex="-1" data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"><span class="sr-only">Toggle Dropdown</span></button>
                                            <div class="dropdown-menu">

                                            @if(hasPermission('fund_transfer_update') == true)
                                                <a href="{{route('fund-transfer.edit',$fund_transfer->id)}}" class="dropdown-item"><i class="fas fa-edit" aria-hidden="true"></i> {{ __('levels.edit') }}</a>
                                            @endif
                                            @if(hasPermission('fund_transfer_delete') == true )
                                                <form id="delete" value="Test" action="{{route('fund-transfer.delete',$fund_transfer->id)}}" method="POST" data-title="{{ __('delete.fund_transfer') }}">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="dropdown-item"><i class="fa fa-trash" aria-hidden="true"></i> {{ __('levels.delete') }}</button>
                                                </form>
                                            @endif

                                            </div>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="col-12">
                    <div class="table-responsive">
                        <span>{{ $fund_transfers->links() }}</span>
                        <p class="p-2 small">
                            {!! __('Showing') !!}
                            <span class="font-medium">{{ $fund_transfers->firstItem() }}</span>
                            {!! __('to') !!}
                            <span class="font-medium">{{ $fund_transfers->lastItem() }}</span>
                            {!! __('of') !!}
                            <span class="font-medium">{{ $fund_transfers->total() }}</span>
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
@endpush
<!-- js  -->
@push('scripts')
@endpush


