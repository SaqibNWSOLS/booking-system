@extends('layouts.auth_app')

@section('content')
<body>
    <section class="auth-page">
        <div class="left-area">
            <h4 class="text-center mb-5 pb-4">Forgot Password? 🔒</h4>
             <div class="text-center">
                    <a href="{{ url('/') }}" class="fs-7">Click to return to home?</a>
                </div>
            <p> @if(!empty(session('success'))) {{session('success')}} @endif</p>
              <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                <div class="form-group mb-3">
                    <label>Email</label>
                    <div class="icon-wraper">
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="forgot-password-email" name="email" value="{{ old('email') }}" placeholder="john@example.com" aria-describedby="forgot-password-email" tabindex="1" autofocus />
             @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror

                            
                        <img class="icon" src="{{asset('assets/icons/email-l.svg')}}" />
                    </div>
                </div>
              

                <div class="text-end">
          <a href="{{ route('login') }}"> <i data-feather="chevron-left"></i> Back to login </a>
                </div>
                <button class="btn btn-primary mt-4 w-100">Send reset link</button>
            </form>
        </div>
        <div class="right-area">
            <div class="logo">
                <a href="{{url('/')}}"><img src="{{asset('assets/images/logo.png')}}" /></a>
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
