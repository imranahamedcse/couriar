@include('backend.partials.header')
    <!-- ============================================================== -->
    <!-- signup form  -->
    <!-- ============================================================== -->
    <form class="splash-container" method="POST" action="{{ route('merchant.sign-up-store') }}">
        @csrf
        <div class="card">
            <div class="card-header text-center">
                <a href="{{url('/')}}">
                    <img class="logo-img" src="{{asset('backend')}}/images/logo.png" alt="logo">
                </a>
                <h3 class="mb-1">Registrations Form</h3>
                <p>Please enter your user information.</p>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <input id="business_name" type="text" class="form-control form-control-lg @error('business_name') is-invalid @enderror" name="business_name" value="{{ old('business_name') }}"  autocomplete="business_name" autofocus placeholder="Business Name *">
                    @error('business_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input id="first_name" type="text" class="form-control form-control-lg @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}"  autocomplete="first_name" autofocus placeholder="First Name *">
                    @error('first_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input id="last_name" type="text" class="form-control form-control-lg @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}"  autocomplete="last_name" autofocus placeholder="Last Name">
                    @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" placeholder="Address *">{{ old('address')  }}</textarea>
                    @error('address')
                    <small class="text-danger mt-2">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <input id="mobile" type="number" class="form-control form-control-lg @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}"  autocomplete="mobile" placeholder="Mobile *">
                    @error('mobile')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password"  autocomplete="new-password" placeholder="Password *">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="custom-control custom-checkbox">
                        <input id="merchant_registration_checkbox" name="policy" class="custom-control-input" type="checkbox"><span class="custom-control-label">I agree to <a href="#">E-courier</a> Privacy Policy & Terms.</span>
                    </label>
                </div>
                <div class="form-group pt-2">
                    <button id="merchant_registration_submit" class="btn btn-block btn-primary" type="submit">Register My Account</button>
                </div>
            </div>
            <div class="card-footer bg-white">
                <p>Already member? <a href="{{ route('login') }}" class="text-secondary">Login Here.</a></p>
            </div>
        </div>
    </form>
    <!-- ============================================================== -->
    <!-- end signup form  -->
    <!-- ============================================================== -->
@include('backend.partials.footer')
