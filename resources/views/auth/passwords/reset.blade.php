@extends('layouts.auth_app')

@section('content')
<body>
    <section class="auth-page">
        <div class="left-area">
            <h4 class="text-center mb-5 pb-4">Reset Password? 🔒</h4>
              <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">
                       
                         <div class="form-group mb-3">
                    <label>{{ __('Email Address') }}</label>
                    <div class="icon-wraper">
                         <input id="email" type="email" readonly class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

           
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            
                        <img class="icon" src="{{asset('assets/icons/email-l.svg')}}" />
                    </div>
                </div>
                        
                         <div class="form-group mb-3">
                    <label>{{ __('Password') }}</label>
                    <div class="icon-wraper password-group">
                        <input   type="password" class="password-box form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" id="passInput" />
                         @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        <div class="icon password-visibility"><i class="fa fa-eye"></i></div>
                    </div>
                </div>
                 <div class="form-group mb-3">
                    <label>{{ __('Confirm Password') }}</label>
                    <div class="icon-wraper password-group">
                        <input type="password" class="password-box form-control" name="password_confirmation" required autocomplete="new-password"id="passInput" />
                        <div class="icon password-visibility"><i class="fa fa-eye"></i></div>
                    </div>
                </div>

                       
                       

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
        </div>
        <div class="right-area">
            <div class="logo">
                <img src="{{asset('assets/images/logo.png')}}" />
            </div>
        </div>
    </section>
</body>

<script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"
    ></script>

<script>
    $(document).ready(function(){
        $('#showPass').on('click', function(){
            var passInput=$("#passInput");
            if(passInput.attr('type')==='password')
                {
                passInput.attr('type','text');
                $(this).closest(".icon-wraper").addClass("text-visible")
            }else{
                passInput.attr('type','password');
                $(this).closest(".icon-wraper").removeClass("text-visible")
            }
        })
    })
</script>
@endsection
