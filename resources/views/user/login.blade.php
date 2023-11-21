@extends('layouts.app')
@include('Components.nav')
<main class="login-form">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-8 col-md-6 col-lg-4">
                <div class="card">
                    <h3 class="card-header text-center">Login</h3>
                    @if (\Session::has('message'))
                        <div class="alert alert-danger">
                            {{ \Session::get('message') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <img src="https://nextlevelpc.ma/wp-content/uploads/2021/05/logo-02-1-1024x1024.png"
                                 class="img-fluid" alt="Logo" style="max-width: 35%">
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <input type="text" placeholder="Email" id="email" class="form-control"
                                       name="email" autofocus>
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <input type="password" placeholder="Password" id="password" class="form-control"
                                       name="password">
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn text-white btn-block"
                                        style="background-color: #83299B">Sign
                                    in
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@include('Components.footer')
