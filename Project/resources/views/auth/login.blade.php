@extends('layouts.app')

@section('content')
    <div id="login_page_content">
        <div id="main_image_div">
            <img src="{{ url('/images/login_page.png') }}" id="main_image"/>
        </div>
        <div id="login_register_content">
            <h1>Log In</h1>
            <form class="form-group bg-light bg-opacity-25 mx-auto mt-5" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="form-floating mb-3">
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required placeholder="email">
                    <label for="email">Email</label>
                </div>
                @if ($errors->has('email'))
                    <span class="error">
                    {{ $errors->first('email') }}
                    </span>
                @endif
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password" name="password" required placeholder="password">
                    <label for="password">Password</label>
                </div>
                @if ($errors->has('password'))
                    <span class="error">
                        {{ $errors->first('password') }}
                    </span>
                @endif
                <label>
                    <input type="checkbox" class="form-check-input" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me</input>
                </label>
                <div class="buttons" id="butons_login_page">
                    <button class="btn btn-dark" type="submit">Login</button> 
                    <a class="btn btn-outline-dark hovered_button" href="{{ route('register') }}">Register</a>
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
