@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-6 mt-5">
            <div class="col">
                <p class="h1 text-primary font-weight-bold">MaybeFacebook</p>
                <p class="h2 text-dark">Recent logins</p>
                <p class="h6 text-dark">Click your picture or add an account.</p>
            </div>
            <div class="col d-flex flex-wrap">
                <div class="card col-5 m-1">
                    <div class="card-body">
                        <div class="card-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle h5"    viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                            </svg>
                      </div>
                      <a href="#" class="btn btn-outline-primary">Add Account</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 mt-5 d-flex justify-content-center align-items-center">
            <div class="col-10 shadow p-3 mb-5 bg-white rounded">
                <form method="POST" class="p-2" action="{{ route('login') }}">
                    @csrf
    
                    <div class="form-group">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email address">
    
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
    
                    <div class="form-group">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
    
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button class="font-weight-bold btn btn-primary w-100">Log In</button>
                        
                    </div>
                </form>
                <div class="">
                    <div class="d-flex justify-content-center mt-2">
                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        @endif
                    </div>
                    <hr>
                    <a href="/register" class="col-6 offset-3 font-weight-bold btn btn-success w-100">Create New Account</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
