@extends('layouts.admin_auth')
@section('title')
    @langg('Admin login')
@endsection
@section('content')

<div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
    <div class="card card-primary logincard">
      <div class="card-header d-flex justify-content-between">
          <h4>@langg('Admin Login')</h4>
          <a href="{{url('/')}}">@langg('Home')</a>
        </div>

      <div class="card-body">
          @if(session()->has('error'))
            <div class="my-2 text-center creds  p-2">
              <span class="text-danger  mt-2">{{ session('error') }}</span>
            </div>
         @endif
        <form method="POST" action="" class="needs-validation">
            @csrf
                <div class="form-group">
                    <label for="email">@langg('Email or Username')</label>
                    <input id="email" type="text" class="form-control  @error('email') is-invalid  @enderror" name="user" tabindex="1" required>
                    @error('user')
                     <span class="text-danger mt-2">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="control-label">@langg('Password')</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid  @enderror " name="password" tabindex="2">
                    @error('password')
                        <span class="text-danger mt-2">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group text-right">
                <a href="{{route('admin.forgot.password')}}" class="float-left mt-3">
                    @langg('Forgot Password')?
                </a>
                <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right" tabindex="4">
                    @langg('Login')
                </button>
                </div>
            </form>
      </div>
    </div>

  </div>

@endsection

@push('style')
    <style>
        .logincard{
            margin-top: 250px !important;
            border-radius: 3px
        }
        .creds{
            background-color: #fc544b19;
            border-radius: 3px
        }
    </style>
@endpush
