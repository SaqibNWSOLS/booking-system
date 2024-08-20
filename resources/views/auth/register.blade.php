@extends('layouts.auth_app')

@section('content')
<body>
    <section class="auth-page">
        <div class="left-area">
            <h4 class="text-center mb-5 pb-4">Sign Up</h4>
             <div class="text-center">
                    <a href="{{ url('/') }}" class="fs-7">Click to return to home?</a>
                </div>
              <form method="POST" id="form1" action="{{ route('register') }}">
                        @csrf
            
            <div class="form-group mb-3">
                    <label>Name</label>
                    <div class="icon-wraper">
                      <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="email" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        <img class="icon" src="{{asset('assets/icons/email-l.svg')}}" />
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label>Email</label>
                    <div class="icon-wraper">
                      <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        <img class="icon" src="{{asset('assets/icons/email-l.svg')}}" />
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label>Password</label>
                    <div class="icon-wraper password-group">
                        <input type="password" name="password" required id="password" class="password-box form-control" id="passInput" />
                        <div class="icon password-visibility"><i class="fa fa-eye"></i></div>
                    </div>
                </div>

                 <div class="form-group mb-3">
                    <label>Password</label>
                    <div class="icon-wraper password-group">
                        <input type="password" name="password_confirmation"  data-pristine-equals="#password"  class="password-box form-control" id="passInput" />
                        <div class="icon password-visibility"><i class="fa fa-eye"></i></div>
                    </div>
                </div>

                <div class="text-end">
                    <a href="{{ route('password.request') }}" class="fs-7">Forgot your password?</a>
                </div>
                <button class="btn btn-primary mt-4 w-100">Sign Up</button>
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
