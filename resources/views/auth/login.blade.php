@include('backend.partials.header')
{{-- <div class="row"> --}}

    {{-- <div class="col-6"> --}}
        <div class="splash-container">
            <div class="card ">
                <div class="card-header text-center">
                    <a href="{{url('/')}}">
                        <img class="logo-img" src="{{ settings()->logo_image }}" height="60px" alt="logo">
                    </a>
                    <span class="splash-description">Please enter your user information.</span>
                    </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <input id="email" type="text" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" required autocomplete="email" autofocus  placeholder="Enter Email or Mobile"
                            @if(Cookie::has('useremail')) ? value="{{Cookie::get('useremail')}}" : value="{{ old('email') }}" @endif>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password"
                            @if(Cookie::has('userpassword')) value="{{Cookie::get('userpassword')}}" @endif>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="custom-control custom-checkbox">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}
                                @if(Cookie::has('useremail')) checked @endif>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
                    </form>
                </div>
                <div class="card-footer bg-white p-0  ">
                    <div class="card-footer-item card-footer-item-bordered">
                        <!-- <a href="{{ route('register') }}" class="footer-link">Create An Account</a></div> -->
                        <a href="{{ route('merchant.sign-up') }}" class="footer-link">Sign up here</a></div>
                    <div class="card-footer-item card-footer-item-bordered">
                        <a href="{{ route('password.request') }}" class="footer-link">Forgot Password</a>
                    </div>
                </div>
            </div>
        </div>
    {{-- </div>
    <div class="col-6">

    </div>
</div> --}}

@include('backend.partials.footer')
