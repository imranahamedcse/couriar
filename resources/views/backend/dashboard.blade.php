
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->

        @extends('backend.partials.master')
        @section('title','Dashbord | Index')
        @section('maincontent')

            <div class="container-fluid dashboard-content ">
                <!-- ============================================================== -->
                <!-- pageheader  -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{url('/')}}" class="breadcrumb-link">{{ __('menus.dashboard') }}</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">{{settings()->name }} {{ __('menus.dashboard') }} </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end pageheader  -->
                <!-- ============================================================== -->
                <div class="ecommerce-widget">
                    <div class="row">
                        <div class="col-12 text-right">

                            <div class="dropdown">
                                <div>
                                    <form action="{{ route('dashboard.index',['test'=>'custom']) }}" method="get" >
                                        <button type="submit" class="btn btn-sm btn-primary float-right">{{ __('levels.filter') }}</button>
                                        <input type="hidden" name="days" value="custom"/>
                                        <input type="text" name="filter_date" placeholder="YYYY-MM-DD" autocomplete="off" class="form-control date_range_picker float-right" value="{{ $request->filter_date }}" style="width: 15%;" />
                                    </form>
                                </div>

                                <button class="btn   dropdown-toggle mb-2" type="button" id="dropdownMenuButton" style="background:unset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @if ($request->days     == 'today')
                                        {{ __('dashboard.today') }}
                                    @elseif ($request->days == 'yesterday')
                                        {{ __('dashboard.yesterday') }}
                                    @elseif ($request->days == 'week')
                                        {{ __('dashboard.last_week') }}
                                    @elseif ($request->days == '15days')
                                        {{ __('dashboard.last_15_days') }}
                                    @elseif ($request->days == 'month')
                                        {{ __('dashboard.last_month') }}
                                    @elseif($request->days == 'custom')
                                        {{ __('dashboard.custom') }}
                                    @else
                                        {{ __('dashboard.last_week') }}
                                    @endif
                                </button>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                  <a class="dropdown-item" href="{{ route('dashboard.index',['days'=>'today']) }}">{{ __('dashboard.today') }}</a>
                                  <a class="dropdown-item" href="{{ route('dashboard.index',['days'=>'yesterday']) }}">{{ __('dashboard.yesterday') }}</a>
                                  <a class="dropdown-item" href="{{ route('dashboard.index',['days'=>'week']) }}">{{ __('dashboard.last_week') }}</a>
                                  <a class="dropdown-item" href="{{ route('dashboard.index',['days'=>'15days']) }}">{{ __('dashboard.last_15_days') }}</a>
                                  <a class="dropdown-item" href="{{ route('dashboard.index',['days'=>'month']) }}">{{ __('dashboard.last_month') }}</a>

                                </div>
                              </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- ============================================================== -->
                        <!-- sales  -->
                        <!-- ============================================================== -->
                        @if(hasPermission('total_parcel') == true)
                        <div class="col-6 col-lg-2">
                            <div class="card border-3 border-top border-top-primary total-card-color color-yellow">
                                <div class="card-body total-card-body">
                                    <div class="text-center">
                                        <label class="icon">
                                            <i class="fa fa-box-open"></i>
                                        </label>
                                        <div class="box-content">
                                            <h5 class="text-muted">{{ __('dashboard.total_parcel') }}</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">{{ $data['total_parcel'] }}</h1>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- ============================================================== -->
                        <!-- end sales  -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- new customer  -->
                        <!-- ============================================================== -->
                        @if(hasPermission('total_user') == true)
                        <div class="col-6 col-lg-2">
                            <div class="card border-3 border-top border-top-primary total-card-color color-blue">
                                <div class="card-body total-card-body">
                                    <div class="text-center  ">
                                        <label class="icon">
                                            <i class="fa fa-users"></i>
                                        </label>
                                        <div class="box-content">
                                            <h5 class="text-muted">{{ __('dashboard.total_user')}} </h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">{{ $data['total_user'] }}</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- ============================================================== -->
                        <!-- end new customer  -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- visitor  -->
                        <!-- ============================================================== -->
                        @if(hasPermission('total_merchant') == true)
                        <div class="col-6 col-lg-2">
                            <div class="card border-3 border-top border-top-primary total-card-color color-green">
                                <div class="card-body total-card-body">
                                    <div class="text-center">
                                        <label class="icon">
                                            <i class="fa fa-users"></i>
                                        </label>
                                        <div class="box-content">
                                            <h5 class="text-muted">{{ __('dashboard.total_merchant')}}</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">{{ $data['total_merchant'] }}</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- ============================================================== -->
                        <!-- end visitor  -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- total orders  -->
                        <!-- ============================================================== -->
                        @if(hasPermission('total_delivery_man') == true)
                        <div class="col-6 col-lg-2">
                            <div class="card border-3 border-top border-top-primary total-card-color color-red">
                                <div class="card-body total-card-body">
                                    <div class="text-center">
                                        <label class="icon">
                                            <i class="fas fa-users"></i>
                                        </label>
                                        <div class="box-content">
                                            <h5 class="text-muted">{{ __('dashboard.total_delivery_man')}}</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">{{ $data['total_delivery_man'] }}</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- ============================================================== -->
                        <!-- end total orders  -->


                        <!-- total hubs  -->
                        <!-- ============================================================== -->

                        @if(hasPermission('total_hubs') == true)
                        <div class="col-6 col-lg-2">
                            <div class="card border-3 border-top border-top-primary total-card-color color-gray">
                                <div class="card-body total-card-body">
                                    <div class="text-center">
                                        <label class="icon">
                                            <i class="fas fa-warehouse"></i>
                                        </label>
                                        <div class="box-content">
                                            <h5 class="text-muted">{{ __('dashboard.total_hubs')}}</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">{{ $data['total_hubs'] }}</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- ============================================================== -->
                        <!-- end total orders  -->
                        <!-- total accounts  -->
                        <!-- ============================================================== -->

                        @if(hasPermission('total_accounts') == true)
                        <div class="col-6 col-lg-2">
                            <div class="card border-3 border-top border-top-primary total-card-color color-purple">
                                <div class="card-body total-card-body">
                                    <div class="text-center">
                                        <label class="icon">
                                            <i class="fa fa-credit-card"></i>
                                        </label>
                                        <div class="box-content">
                                            <h5 class="text-muted">{{ __('dashboard.total_accounts')}}</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">{{ $data['total_accounts'] }}</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- ============================================================== -->
                        <!-- end total orders  -->
                        <!-- ============================================================== -->
                    </div>


                    <div class="row">
                        <!-- ============================================================== -->
                        <!-- total pending  -->
                        <!-- ============================================================== -->
                        @if(hasPermission('total_parcels_pending') == true)
                        <div class="col-6 col-lg-2">
                            <div class="card border-3 border-top border-top-primary total-card-color color-aquamarine">
                                <div class="card-body total-card-body">
                                    <div class="text-center">
                                        <label class="icon">
                                            <i class="fa fa-truck-loading"></i>
                                        </label>
                                        <div class="box-content">
                                            <h5 class="text-muted">{{ __('dashboard.total_pending') }}</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">{{ $data['total_pending'] }}</h1>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- ============================================================== -->
                        <!-- end total pending  -->
                        <!-- total pickup assigned  -->
                        <!-- ============================================================== -->
                        @if(hasPermission('total_pickup_assigned') == true)
                        <div class="col-6 col-lg-2">
                            <div class="card border-3 border-top border-top-primary total-card-color color-darkorange">
                                <div class="card-body total-card-body">
                                    <div class="text-center">
                                        <label class="icon">
                                            <i class="fas fa-truck"></i>
                                        </label>
                                        <div class="box-content">
                                            <h5 class="text-muted">{{ __('dashboard.total_pickup_assigned')}}</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">{{ $data['total_pickup_assigned'] }}</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- ============================================================== -->
                        <!-- end total pickup assigned -->


                      <!-- total warehouse-->
                        <!-- ============================================================== -->
                        @if(hasPermission('total_received_warehouse') == true)
                        <div class="col-6 col-lg-2">
                            <div class="card border-3 border-top border-top-primary total-card-color color-darkslategrey">
                                <div class="card-body total-card-body">
                                    <div class="text-center">
                                        <label class="icon">
                                            <i class="fas fa-warehouse"></i>
                                        </label>
                                        <div class="box-content">
                                            <h5 class="text-muted font-12">{{ __('dashboard.total_warehouse') }}</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">{{ $data['total_received_warehouse'] }}</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- ============================================================== -->
                        <!-- end total warehouse -->


                      <!-- total deliveryman  assigned  -->
                        <!-- ============================================================== -->
                        @if(hasPermission('total_deliveryman_assigned') == true)
                        <div class="col-6 col-lg-2">
                            <div class="card border-3 border-top border-top-primary total-card-color color-yellowgreen">
                                <div class="card-body total-card-body">
                                    <div class="text-center">
                                        <label class="icon">
                                            <i class="fas fa-people-carry"></i>
                                        </label>
                                        <div class="box-content">
                                            <h5 class="text-muted font-12">{{ __('dashboard.total_delivery_man_assigned') }}</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">{{ $data['total_deliveryman_assigned'] }}</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- ============================================================== -->
                        <!-- end total deliveryman assigned -->


                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!--total partial deliverd  -->
                        <!-- ============================================================== -->
                        @if(hasPermission('total_partial_deliverd') == true)
                        <div class="col-6 col-lg-2">
                            <div class="card border-3 border-top border-top-primary total-card-color color-antiquewhite">
                                <div class="card-body total-card-body">
                                    <div class="text-center">
                                        <label class="icon">
                                            <i class="fas fa-handshake"></i>
                                        </label>
                                        <div class="box-content">
                                            <h5 class="text-muted">{{ __('dashboard.total_partial_deliverd')}} </h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">{{ $data['total_partial_deliverd'] }}</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- ============================================================== -->
                        <!-- end total partial deliverd -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- total delivered  -->
                        <!-- ============================================================== -->
                        @if(hasPermission('total_parcels_deliverd') == true)
                        <div class="col-6 col-lg-2">
                            <div class="card border-3 border-top border-top-primary total-card-color color-greennormal">
                                <div class="card-body total-card-body">
                                    <div class="text-center">
                                        <label class="icon">
                                            <i class="fas fa-handshake"></i>
                                        </label>
                                        <div class="box-content">
                                            <h5 class="text-muted">{{ __('dashboard.total_deliverd')}}</h5>
                                            <div class="metric-value d-inline-block">
                                                <h1 class="mb-1">{{ $data['total_deliverd'] }}</h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- ============================================================== -->
                        <!-- end total deliverd  -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->


                    </div>
                    {{-- salary and account section --}}

                    @if(hasPermission('calendar_read') == true)
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div id='calendar' class="dashboard-calendar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row">

                        @if(hasPermission('recent_accounts') == true)
                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="text-muted mb-0">{{ __('dashboard.recent') }}  {{ __('account.title') }} {{ __('dashboard.balance') }}</h5>
                                    </div>
                                    <div class="card-body">


                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead class=" ">
                                                    <tr>

                                                        <th>{{ __('levels.account_no') }} | {{__('levels.name')}}</th>

                                                        <th>{{ __('levels.balance') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($data['recent_accounts'] as $account)
                                                        <tr>

                                                            <td>
                                                                @if($account->gateway == 1)
                                                                    {{@$account->user->name}} (Cash)
                                                                @else
                                                                    @if($account->gateway == 3)
                                                                        bKash ,
                                                                    @elseif ($account->gateway == 4)
                                                                        Rocket ,
                                                                    @elseif ($account->gateway == 5)
                                                                        Nagad ,
                                                                    @endif
                                                                    {{$account->account_holder_name}}
                                                                    @if(
                                                                        $account->account_no ||
                                                                        $account->account_no ||
                                                                        $account->branch_name ||
                                                                        $account->mobile
                                                                    )
                                                                    ({{$account->account_no}}
                                                                    {{$account->branch_name}}
                                                                    {{$account->mobile}}) @endif
                                                                @endif
                                                            </td>

                                                            <td class="font-15">{{settings()->currency}} {{$account->balance}}</td>
                                                        </tr>
                                                    @endforeach

                                                    <tr class="text-primary">

                                                        <td colspan="">{{ __('dashboard.total_balance') }}</td>
                                                        <td colspan="" class="font-15">{{ settings()->currency }} {{number_format($data['recent_accounts']->sum('balance'),2)}}</td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="7"><a href="{{ route('accounts.index') }}" class="btn btn-outline-light float-right">{{ __('dashboard.view_details') }}</a></td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(hasPermission('recent_salary') == true)
                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="text-muted mb-0" style="padding-left: 25px"> {{ __('dashboard.recent') }} {{ __('salary.title') }}</h5>
                                    </div>
                                    <div class="card-body dashboard-salary" >
                                            <div class="row" >
                                                <div class="col-12 ">
                                                    <table class="table table-striped">
                                                        <thead class=" ">
                                                            <tr>
                                                                <th  style="padding-left: 25px">{{__('user.title')}}</th>
                                                                <th class="text-center">{{ __('levels.balance') }}</th>
                                                            </tr>
                                                        </thead>
                                                        @foreach ($data['salaries'] as $salary)
                                                            <tr>
                                                                <td >
                                                                    <div class="d-flex align-items-center">
                                                                    <p class="ml-3">{{ $salary->user->name }}</p>
                                                                    </div>
                                                            </td>
                                                                <td >
                                                                    <div class="d-flex align-items-center">
                                                                        <p class=" " >{{ settings()->currency }} {{ number_format($salary->amount,2) }}</p>
                                                                    </div>
                                                            </td>
                                                            </tr>
                                                        @endforeach


                                                        <tr class="text-primary ">
                                                            <td >
                                                                <div class="d-flex align-items-center">
                                                                    <p class="ml-3 " style="color:#5969ff!important">{{ __('dashboard.total_generated_month') }}</p>
                                                                </div>
                                                            </td>
                                                            <td >
                                                                <div class="d-flex align-items-center">
                                                                    <p class=" " >{{ $data['total_generated_month'] }}</p>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <tr class="text-primary "  >
                                                            <td >
                                                                <div class="d-flex align-items-center">
                                                                    <p class="ml-3  " style="color: #5969ff!important" >{{ __('dashboard.total_generated_amount') }}</p>
                                                                </div>
                                                            </td>
                                                            <td >
                                                                <div class="d-flex align-items-center">
                                                                    <p class=" ">{{ settings()->currency }} {{ number_format($data['total_generated_amount'],2) }}</p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="text-primary ">
                                                            <td >
                                                                <div class="d-flex align-items-center">
                                                                    <p class="ml-3 " style="color:#5969ff!important">{{ __('dashboard.total_paid_amount') }}</p>
                                                                </div>
                                                            </td>
                                                            <td >
                                                                <div class="d-flex align-items-center">
                                                                    <p class=" ">{{ settings()->currency }} {{ number_format($data['total_paid_amount'],2) }}</p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr class="text-primary ">
                                                            <td >
                                                                <div class="d-flex align-items-center">
                                                                    <p class="ml-3 " style="color:#5969ff!important">{{ __('dashboard.total_unpaid_amount') }}</p>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <p class=" ">{{ settings()->currency }} {{ number_format($data['total_unpaid_amount'],2) }}</p>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="7"><a href="{{ route('salary.index') }}" class="btn btn-outline-light float-right">{{ __('dashboard.view_details') }}</a></td>
                                                        </tr>

                                                    </table>
                                                </div>
                                            </div>

                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(hasPermission('recent_hub' )== true)
                            {{-- hub wise parcels --}}
                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="text-muted mb-0" style="padding-left: 25px"> {{ __('dashboard.recent') }} {{ __('hub.title') }}</h5>
                                    </div>
                                    <div class="card-body dashboard-salary" style="padding-bottom: 30px">


                                            <div class="row" >
                                                <div class="col-12 ">
                                                    <table class="table table-striped" style="margin-bottom: -15px!important;">
                                                        <thead class=" ">
                                                            <tr>

                                                                <th  style="padding-left: 25px">{{__('hub.title')}}</th>

                                                                <th class="text-center">{{ __('parcel.title') }}</th>
                                                            </tr>
                                                        </thead>
                                                        @foreach ($data['hub_parcels'] as $hub)
                                                            <tr>
                                                                <td >
                                                                    <div class="d-flex align-items-center">
                                                                    <p class="ml-3">{{ $hub->name }}</p>
                                                                    </div>
                                                            </td>
                                                                <td >
                                                                    <div class="d-flex align-items-center">
                                                                        <p class=" " > {{ $hub->parcels->count() }}</p>
                                                                    </div>
                                                            </td>
                                                            </tr>
                                                        @endforeach


                                                        <tr>
                                                            <td colspan="7"><a href="{{ route('hubs.index') }}" class="btn btn-outline-light float-right">{{ __('dashboard.view_details') }}</a></td>
                                                        </tr>

                                                    </table>
                                                </div>
                                            </div>

                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>

                    @if(hasPermission('all_statements') == true)

                    <p class="h4">{{ __('dashboard.statements') }}</p>
                    <div class="row">
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header"> <small>{{ __('dashboard.courier') }} {{ __('dashboard.statements') }}</small></div>
                                <div class="card-body">
                                    <h5 class="text-muted">{{ __('income.title') }} | {{ __('expense.title') }} | {{ __('dashboard.vat') }} | {{ __('dashboard.profit') }}</h5>
                                    <div class="metric-value d-inline-block">
                                        <h3 class="mb-1">{{settings()->currency}}{{$c_income}} | {{settings()->currency}}{{$c_expense}} | {{settings()->currency}}{{$v_income - $v_expense}} | {{settings()->currency}}{{$c_income - $c_expense}} </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header"><small>{{ __('dashboard.delivery_man') }}  {{ __('dashboard.statements') }}</small></div>
                                <div class="card-body">
                                    <h5 class="text-muted">{{ __('income.title') }} | {{ __('expense.title') }} | {{ __('dashboard.balance') }}</h5>
                                    <div class="metric-value d-inline-block">
                                        <h3 class="mb-1">{{settings()->currency}}{{$d_income}} | {{settings()->currency}}{{$d_expense}} | {{settings()->currency}}{{$d_income - $d_expense}}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header"> <small>{{  __('dashboard.merchant')}}  {{ __('dashboard.statements') }}</small></div>
                                <div class="card-body">

                                    <h5 class="text-muted">{{ __('income.title') }} | {{ __('expense.title') }} | {{ __('dashboard.balance') }}</h5>
                                    <div class="metric-value d-inline-block">
                                        <h3 class="mb-1">{{settings()->currency}}{{$m_income}} | {{settings()->currency}}{{$m_expense}} | {{settings()->currency}}{{$m_income - $m_expense}}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header"> <small>{{ __('dashboard.vat') }}  {{ __('dashboard.statements') }}</small></div>
                                <div class="card-body">

                                    <h5 class="text-muted">{{ __('income.title') }} | {{ __('expense.title') }} | {{ __('dashboard.balance') }}</h5>
                                    <div class="metric-value d-inline-block">
                                        <h3 class="mb-1">{{settings()->currency}}{{$v_income}} | {{settings()->currency}}{{$v_expense}} | {{settings()->currency}}{{$v_income - $v_expense}}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <small>{{ __('dashboard.bank') }}  {{ __('dashboard.statements') }}</small>
                                </div>
                                <div class="card-body">
                                    <h5 class="text-muted">{{ __('income.title') }} | {{ __('expense.title') }} | {{ __('dashboard.balance') }}</h5>
                                    <div class="metric-value d-inline-block">
                                        <h3 class="mb-1">{{settings()->currency}}{{$b_income}} | {{settings()->currency}}{{$b_expense}} | {{settings()->currency}}{{$b_income - $b_expense}}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <small>{{ __('hub.title') }}  {{ __('dashboard.statements') }}</small>
                                </div>
                                <div class="card-body">
                                    <h5 class="text-muted">{{ __('income.title') }} | {{ __('expense.title') }} | {{ __('dashboard.balance') }}</h5>
                                    <div class="metric-value d-inline-block">
                                        <h3 class="mb-1">{{settings()->currency}}{{$h_income}} | {{settings()->currency}}{{$h_expense}} | {{settings()->currency}}{{$h_income - $h_expense}}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>

                <div class="col-12">
                    <div class="row">


                        @if(hasPermission('income_expense_charts') == true)
                        {{-- courier revinue  charts--}}
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header chart-select ">
                                    {{ __('income.title') }} / {{ __('expense.title') }}
                                </h5>
                                <div class="card-body">
                                    <canvas id="myChartincomeexpense" width="400" height="400"></canvas>
                                </div>
                                <div class="card-footer">
                                    <p class="display-7 font-weight-bold">
                                        <span class="legend-text text-primary d-inline-block">{{ settings()->currency }} {{ $data['income'] }}</span>
                                        <span class="text-secondary float-right">{{ settings()->currency }} {{ $data['expense'] }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        {{-- courier revinue charts--}}
                        @endif


                        @if(hasPermission('merchant_revenue_charts') == true)
                        {{-- merchant revinue  charts--}}
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header"> {{ __('dashboard.merchant') }} {{ __('dashboard.revenue') }}</h5>
                                <div class="card-body">
                                    <canvas id="myChartmerchantrevenue" width="400" height="400"></canvas>
                                </div>
                                <div class="card-footer">
                                    <p class="display-7 font-weight-bold">
                                        <span class="text-primary d-inline-block">
                                            {{ settings()->currency }} {{ $data['merchantIncome'] }}
                                        </span>
                                        <span class="text-secondary float-right">
                                            {{ settings()->currency }} {{ $data['merchantExpense'] }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        {{-- merchant revinue charts--}}
                        @endif

                        @if(hasPermission('deliveryman_revenue_charts') == true)
                        {{-- delivery man revinue  charts--}}
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header"> {{__('dashboard.delivery_man') }} {{ __('dashboard.revenue') }}</h5>
                                <div class="card-body">
                                    <canvas id="myChartdeliverymanrevenue" width="400" height="400"></canvas>
                                </div>
                                <div class="card-footer">
                                    <p class="display-7 font-weight-bold">
                                        <span class="text-primary d-inline-block">
                                            {{ settings()->currency }} {{ $data['deliverymanIncome'] }}
                                        </span>
                                        <span class="text-secondary float-right">
                                            {{ settings()->currency }} {{ $data['deliverymanExpense'] }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        {{-- delivery man revinue  charts--}}
                        @endif


                        @if(hasPermission('courier_revenue_charts') == true)
                        {{--Courier revinue pie charts--}}
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header"> {{ __('dashboard.courier') }} {{ __('dashboard.revenue') }}</h5>
                                <div class="card-body">
                                    <canvas id="MychartsCourierRev" width="400" height="400"></canvas>
                                </div>
                                <div class="card-footer">
                                    <p class="display-7 font-weight-bold">
                                        <span class="text-primary d-inline-block">{{ settings()->currency }} {{ $data['courier_income'] }}</span>
                                        <span class="text-secondary float-right">{{ settings()->currency }} {{ $data['courier_expense'] }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        {{-- courier revinue pie charts--}}
                        @endif



                    </div>
                </div>
                <!-- recent parcel  -->


            <div class="col-12" >
                <div class="row">

            @if(hasPermission('recent_parcels') == true)
            <!-- ============================================================== -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">{{ __('dashboard.recent') }} {{ __('parcel.title') }}</h5>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="bg-light">
                                    <tr>
                                        <th>{{ __('###') }}</th>
                                        <th>{{ __('parcel.customer_info') }}</th>
                                        <th>{{ __('parcel.merchant') }}</th>
                                        <th>{{ __('parcel.parcel_info')}}</th>
                                        <th>{{ __('parcel.status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach($data['recent_parcels'] as $parcel)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td class="merchantpayment">
                                                <p>{{$parcel->customer_name}}</p>
                                                <p>{{$parcel->customer_phone}}</p>
                                                <p>{{$parcel->customer_address}}</p>
                                            </td>
                                            <td class="merchantpayment">
                                                <p>{{$parcel->merchant->business_name}}</p>
                                                <p>{{$parcel->merchant->user->mobile}}</p>
                                                <p>{{$parcel->merchant->address}}</p>
                                            </td>
                                            <td>
                                                {{__('levels.track_id')}}: <span class="active">{{ $parcel->tracking_id }}</span>
                                                <br>
                                                {{__('levels.delivery_type')}}: {{ $parcel->delivery_type_name }}
                                                <br>
                                                {{__('parcel.delivert_time')}}: {{dateFormat($parcel->delivery_date)}}
                                                <br>
                                                {{__('levels.cash_collection')}}: <span class="text-dark">{{settings()->currency}}{{$parcel->cash_collection}}</span>
                                            </td>
                                            <td>{!! $parcel->parcel_status !!} <br>
                                                @if($parcel->partial_delivered && $parcel->status != \App\Enums\ParcelStatus::PARTIAL_DELIVERED)
                                                <span class="badge badge-pill badge-success mt-2">{{trans("parcelStatus." . \App\Enums\ParcelStatus::PARTIAL_DELIVERED)}}</span>
                                            @endif
                                            </td>

                                        </tr>
                                    @endforeach

                                    <tr>
                                        <td colspan="9"><a href="{{ route('parcel.index') }}" class="btn btn-outline-light float-right">{{ __('dashboard.view_details') }}</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end recent parcel  -->
            @endif

            @if(hasPermission('bank_transaction') == true)
                <!-- Bank transaction parcel  -->
            <!-- ============================================================== -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">{{ __('dashboard.bank_transaction') }}</h5>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="bg-light">
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
                                    @foreach ($data['bank_transactions'] as $transaction)
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

                                    <tr>
                                        <td colspan="9"><a href="{{ route('bank-transaction.index') }}" class="btn btn-outline-light float-right">{{ __('dashboard.view_details') }}</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <!-- ============================================================== -->
            <!-- end Bank transaction parcel  -->
        </div>
    </div>

        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
        @endsection();

<!-- css  -->
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="{{ asset('backend/vendor/calender/main.css') }}" />
@endpush
<!-- js  -->
@push('scripts')
@include('backend.dashboard-charts')
@include('backend.calender-js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="{{ asset('backend/js/date-range-picker/dashboard-date-range-picker-custom.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush


