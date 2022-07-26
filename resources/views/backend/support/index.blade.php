@extends('backend.partials.master')
@section('title','Support | List')
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
                            <li class="breadcrumb-item"><a href="{{route('support.index')}}" class="breadcrumb-link">{{ __('support.supprot_list') }}</a></li>
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
                    <div class="col-6">
                        <p class="h3">{{ __('support.supprot') }}</p>
                    </div>
                    @if(hasPermission('support_create') == true )
                    <div class="col-6">
                        <a href="{{route('support.add')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="top" title="{{ __('support.supprot_add') }}"><i class="fa fa-plus"></i></a>
                    </div>
                    @endif
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>{{ __('support.sl') }}</th>
                                    <th>{{ __('support.user_info') }}</th>
                                    <th>{{ __('support.subject') }}</th>
                                    <th>{{ __('support.priority') }}</th>
                                    {{-- <th>{{ __('support.description') }}</th> --}}
                                    <th>{{ __('support.date') }}</th>
                                    @if(hasPermission('support_update') || hasPermission('support_delete'))
                                    <th>{{ __('support.action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach($supports as $support)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>
                                        {{__('support.name')}}: <span class="active">{{ @$support->user->name}}</span>
                                        <br>
                                        {{__('support.email')}}: {{ @$support->user->email}}<br/>
                                        {{__('support.service')}}: {{__('SalaryService.'.$support->service) }}<br/>
                                        {{__('support.department')}}: {{@$support->department->title}}
                                    </td>
                                    <td><a class="active" href="{{ route('support.view',$support->id) }}">{{$support->subject }}</a></td>
                                    <td>{{$support->priority }}</td>
                                    <td>{{dateFormat($support->date) }}</td>

                                    @if(hasPermission('support_read') || hasPermission('support_update') || hasPermission('support_delete'))
                                        <td>
                                            <div class="row">
                                                <button tabindex="-1" data-toggle="dropdown" type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"><span class="sr-only">Toggle Dropdown</span></button>
                                                <div class="dropdown-menu">
                                                    @if(hasPermission('support_read'))
                                                        <a href="{{route('support.view',$support->id)}}" class="dropdown-item"><i class="fas fa-eye" aria-hidden="true"></i> {{ __('levels.view') }}</a>
                                                    @endif
                                                    @if(hasPermission('support_update'))
                                                        <a href="{{route('support.edit',$support->id)}}" class="dropdown-item"><i class="fas fa-edit" aria-hidden="true"></i> {{ __('levels.edit') }}</a>
                                                    @endif
                                                    @if(hasPermission('support_delete'))
                                                        <form id="delete" value="Test" action="{{route('support.delete',$support->id)}}" method="POST" data-title="{{ __('delete.support') }}">
                                                            @method('DELETE')
                                                            @csrf
                                                            <input type="hidden" name="" value="{{ __('support.title') }}" id="deleteTitle">
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


                <div class="px-3 d-flex flex-row-reverse align-items-center">
                    <span>{{ $supports->links() }}</span>
                    <p class="p-2 small">
                        {!! __('Showing') !!}
                        <span class="font-medium">{{ $supports->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-medium">{{ $supports->lastItem() }}</span>
                        {!! __('of') !!}
                        <span class="font-medium">{{ $supports->total() }}</span>
                        {!! __('results') !!}
                    </p>
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


