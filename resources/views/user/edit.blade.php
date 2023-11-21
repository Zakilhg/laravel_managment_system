@extends('layouts.app')
@include('Components.nav')
<main class="edit-form">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-8 col-md-6 col-lg-4">
                <div class="card">
                    <h3 class="card-header text-center">Edit User</h3>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <img src="https://nextlevelpc.ma/wp-content/uploads/2021/05/logo-02-1-1024x1024.png"
                                 class="img-fluid" alt="Logo" style="max-width: 35%">
                        </div>
                        <form action="{{ route('update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3">
                                <input type="text" placeholder="Name" id="name" class="form-control"
                                       name="name" autofocus value="{{ Auth::user()->name }}">
                                @if ($errors->has('name') && old('name') !== Auth::user()->name)
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <input type="text" placeholder="Email" id="email_address" class="form-control"
                                       name="email" value="{{ Auth::user()->email }}" autofocus>
                                @if ($errors->has('email') && old('email') !== Auth::user()->email)
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <input type="password" placeholder="New Password" id="password" class="form-control"
                                       name="password">
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <select name="local" id="local" class="form-control">
                                    <option value="Marrakech" {{ Auth::user()->local == 'Marrakech' ? 'selected' : '' }}>
                                        Marrakech
                                    </option>
                                    <option value="Rabat" {{ Auth::user()->local == 'Rabat' ? 'selected' : '' }}>Rabat
                                    </option>
                                </select>
                                @if ($errors->has('local'))
                                    <span class="text-danger">{{ $errors->first('local') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <label for="image">Profile Picture</label>
                                <input type="file" class="form-control" id="image" name="image">
                                @if ($errors->has('image'))
                                    <span class="text-danger">{{ $errors->first('image') }}</span>
                                @endif
                            </div>
                            <div class="d-grid ">
                                <button type="submit" class="btn text-white btn-block"
                                        style="background-color: #83299B">Save
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
