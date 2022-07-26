@extends('backend.partials.master')
@section('title','Merchants | View')
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
                            <li class="breadcrumb-item"><a href="{{route('dashbaord.index')}}" class="breadcrumb-link">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{route('parcel.index') }}" class="breadcrumb-link">Merchants</a></li>
                            <li class="breadcrumb-item"><a href="" class="breadcrumb-link active">View</a></li>
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
                        <p class="h3"> {{$singleMerchant->business_name}} - ({{$singleMerchant->merchant_unique_id}})</p>
                    </div>
                </div>

                <div class="card-body">
                   <div class="row">
                    <div class="col-4">
                        <div class="card card-fluid">
                            <!-- .card-body -->
                            <div class="card-body text-center">
                                <!-- .user-avatar -->
                                <a href="#" class="user-avatar user-avatar-xl my-3">
                                  <img src="{{asset($singleMerchant->user->upload->original)}}" alt="User Avatar" class="rounded-circle user-avatar-xl">
                                      </a>
                                <!-- /.user-avatar -->
                                <h3 class="card-title mb-2 text-truncate">
                                    <a href="#">{{$singleMerchant->user->name}}</a>
                                </h3>
                                <h6 class="card-subtitle text-muted mb-3"> Email: {{$singleMerchant->user->email}}</h6>
                                <h6 class="card-subtitle text-muted mb-3"> Mobile: {{$singleMerchant->user->mobile}}</h6>
                                <p>
                                    <a href="#" class="btn btn-primary circle">View Profile
                                  <i class="fa fa-arrow-right ml-2"></i>
                                        </a>
                                </p>
                            </div>
                            <!-- /.card-body -->
                            <!-- .card-footer -->
                            <footer class="card-footer p-0">
                                <div class="row">
                                    <div class="col-4">
                                        <!-- .card-footer-item -->
                                        <div class="card-footer-item card-footer-item-bordered">
                                            <!-- .metric -->
                                            <div class="metric">
                                                <h6 class="metric-value"> 54 </h6>
                                                <p class="metric-label"> Total Parcel </p>
                                            </div>
                                            <!-- /.metric -->
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <!-- .card-footer-item -->
                                        <div class="card-footer-item card-footer-item-bordered">
                                            <!-- .metric -->
                                            <div class="metric">
                                                <h6 class="metric-value"> 54 </h6>
                                                <p class="metric-label"> Total Amount </p>
                                            </div>
                                            <!-- /.metric -->
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <!-- .card-footer-item -->
                                        <div class="card-footer-item card-footer-item-bordered">
                                            <!-- .metric -->
                                            <div class="metric">
                                                <h6 class="metric-value"> 54 </h6>
                                                <p class="metric-label"> Due amount </p>
                                            </div>
                                            <!-- /.metric -->
                                        </div>
                                    </div>
                                </div>

                            </footer>
                            <!-- /.card-footer -->
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="section-block">
                            <h5 class="section-title">Merchant Information</h5>
                        </div>
                        <div class="tab-regular">
                            <ul class="nav nav-tabs " id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="parcel-tab" data-toggle="tab" href="#parcel" role="tab" aria-controls="home" aria-selected="true">Parcel</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="account-tab" data-toggle="tab" href="#account" role="tab" aria-controls="account" aria-selected="false">Account Info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#document" role="tab" aria-controls="document" aria-selected="false">Document</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="parcel" role="tabpanel" aria-labelledby="home-tab">
                                    <!---Parcel tab--->
                                    <div class="tab-vertical">
                                        <ul class="nav nav-tabs" id="myTab3" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="home-vertical-tab" data-toggle="tab" href="#delivered" role="tab" aria-controls="home" aria-selected="true">Delivered</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="profile-vertical-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="profile" aria-selected="false">Pending</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="contact-vertical-tab" data-toggle="tab" href="#processing" role="tab" aria-controls="contact" aria-selected="false">Processing</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="contact-vertical-tab" data-toggle="tab" href="#returned" role="tab" aria-controls="contact" aria-selected="false">Returned</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="contact-vertical-tab" data-toggle="tab" href="#cencel" role="tab" aria-controls="contact" aria-selected="false">Cencel</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent3">
                                            <div class="tab-pane fade show active" id="delivered" role="tabpanel" aria-labelledby="delivered-tab">
                                                <table class="table table-striped" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Customer name</th>
                                                            <th>Phone</th>
                                                            <th>Parcel ID</th>
                                                            <th>Address</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>01</td>
                                                            <td>Nurul</td>
                                                            <td>011561541</td>
                                                            <td>46565</td>
                                                            <td>Mirpur</td>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                                                <table class="table table-striped" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Customer name</th>
                                                            <th>Phone</th>
                                                            <th>Parcel ID</th>
                                                            <th>Address</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>01</td>
                                                            <td>Nurul</td>
                                                            <td>011561541</td>
                                                            <td>46565</td>
                                                            <td>Mirpur</td>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="processing" role="tabpanel" aria-labelledby="Processing-tab">
                                                <table class="table table-striped" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Customer name</th>
                                                            <th>Phone</th>
                                                            <th>Parcel ID</th>
                                                            <th>Address</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>01</td>
                                                            <td>Nurul</td>
                                                            <td>011561541</td>
                                                            <td>46565</td>
                                                            <td>Mirpur</td>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="returned" role="tabpanel" aria-labelledby="returned-tab">
                                                <table class="table table-striped" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Customer name</th>
                                                            <th>Phone</th>
                                                            <th>Parcel ID</th>
                                                            <th>Address</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>01</td>
                                                            <td>Nurul</td>
                                                            <td>011561541</td>
                                                            <td>46565</td>
                                                            <td>Mirpur</td>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane fade" id="cencel" role="tabpanel" aria-labelledby="cencel-tab">
                                                <table class="table table-striped" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Customer name</th>
                                                            <th>Phone</th>
                                                            <th>Parcel ID</th>
                                                            <th>Address</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>01</td>
                                                            <td>Nurul</td>
                                                            <td>011561541</td>
                                                            <td>46565</td>
                                                            <td>Mirpur</td>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!---end Parcel tab--->
                                </div>
                                <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="profile-tab">
                                    <h3><!---account tab---></h3>
                                    <p>Nullam et tellus ac ligula condimentum sodales. Aenean tincidunt viverra suscipit. Maecenas id molestie est, a commodo nisi. Quisque fringilla turpis nec elit eleifend vestibulum. Aliquam sed purus in odio ullamcorper congue consectetur in neque. Aenean sem ex, tempor et auctor sed, congue id neque. </p>
                                    <!---end account tab--->
                                </div>
                                <div class="tab-pane fade" id="document" role="tabpanel" aria-labelledby="contact-tab">
                                    <h3><!---document tab---> </h3>
                                    <p>Vivamus pellentesque vestibulum lectus vitae auctor. Maecenas eu sodales arcu. Fusce lobortis, libero ac cursus feugiat, nibh ex ultricies tortor, id dictum massa nisl ac nisi. Fusce a eros pellentesque, ultricies urna nec, consectetur dolor. Nam dapibus scelerisque risus, a commodo mi tempus eu.</p>
                                    <!---end document tab--->
                                </div>
                            </div>
                        </div>
                    </div>
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


