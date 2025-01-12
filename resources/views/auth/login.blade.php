@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="../index2.html"><b>{{ $website->name }}</b></a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Masuk KE Akun Yang Sudah Terdaftar</p>
                <form action="{{ route('login') }}" method="post">
                @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Email">
                        <div class="input-group-text">
                            <span class="bi bi-envelope"></span>
                        </div>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Password">
                        <div class="input-group-text">
                            <span class="bi bi-lock-fill"></span>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>


                        <div class="col-4">
                            <div class="d-grid gap-2"> <button type="submit" class="btn btn-primary">Masuk</button>
                            </div>
                        </div>
                    </div>
                </form>
                <p class="mb-0">
                    <a href="{{ route('register') }}" class="text-center">
                        Belum Memiliki Akun?
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
