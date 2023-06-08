@extends('layouts.app')

@section('content')

  <div id="login_page_content">
    <div id="main_image_div">
        <img src="{{ url('/images/login_page.png') }}" id="main_image"/>
    </div>
    <div id="login_register_content">
      <h1>Register</h1>
      <form class="form-group bg-light bg-opacity-25 p-3 mx-auto mt-5" method="POST" action="{{ route('register') }}" style="width: 20em">
          {{ csrf_field() }}  

          <div class="form-floating mb-3">
            <input class="form-control" placeholder="name" id="name" type="text" name="name" value="{{ old('name') }}" required>
            <label for="name">Name</label>
          </div>
          @if ($errors->has('name'))
            <span class="error">
                {{ $errors->first('name') }}
            </span>
          @endif
          <div class="form-floating mb-3">
            <input class="form-control" placeholder="email" id="email" type="email" name="email" value="{{ old('email') }}" required>
            <label for="email">Email</label>
          </div>
          @if ($errors->has('email'))
            <span class="error">
                {{ $errors->first('email') }}
            </span>
          @endif
          <div class="form-floating mb-3">
            <input class="form-control" placeholder="password" id="password" type="password" name="password" required>
            <label for="password">Password</label>
          </div>
          @if ($errors->has('password'))
            <span class="error">
                {{ $errors->first('password') }}
            </span>
          @endif
          <div class="form-floating mb-3">
            <input class="form-control" placeholder="password" id="password-confirm" type="password" name="password_confirmation" required>
            <label for="password-confirm">Confirm Password</label>
          </div>

          <div class="buttons" id="butons_login_page">
            <button class="btn btn-dark" type="submit">Register</button>
            <a class="btn btn-outline-dark hovered_button" href="{{ route('login') }}">Login</a>
          </div>
      </form>
      <div class="login_other_options">
        <a class="btn btn-primary" href="/auth/google">
            <!-- <i class="fa-brands fa-google"></i> -->
            Sign-in/Sign-up with Google
        </a>
      </div>
    </div>
  </div>
@endsection
