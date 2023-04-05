@extends('layouts.frontend')

@section('title')
   @langg('User Login')
@endsection


@section('content')

<section class="accounts-section">
    <div class="container">
        <div class="accounts-inner">
            <div class="accounts-inner__wrapper bg--section">
                <div class="accounts-left">
                    <div class="accounts-left-content">
                        <div class="section-header">
                            <h3 class="section-header__title mt-0">@lang('Sign in to') {{$gs->title}}</h3>
                        </div>
                        <form class="row gy-4" method="POST" action="{{route('user.login')}}"> 
                            @csrf
                            <div class="col-sm-12">
                                <label for="username" class="form-label">@langg('Email or Username')</label>
                                <input type="text" name="user" class="form-control"  placeholder="@langg('Email or Username')" value="{{old('email')}}" required>
                            </div>
                            <div class="col-sm-12">
                                <label for="username" class="form-label">@langg('Password')</label>
                                <input type="password" name="password" class="form-control" id="password"
                                placeholder="@langg('Password')" required>
                            </div>

                            <div class="col-12 mt-2">
                                <div class="d-flex flex-wrap justify-content-between">
                                    <a href="{{route('user.forgot.password')}}" class="text--base">@langg('Forgot Password ?')</a>
                                </div>
                            </div>

                            @if ($gs->recaptcha)
                            <div class="col-sm-12">
                                {!! NoCaptcha::display() !!}
                                {!! NoCaptcha::renderJs() !!}
                                @error('g-recaptcha-response')
                                <p class="my-2 text--danger">{{$message}}</p>
                                @enderror
                            </div>
                            @endif
                            
                            <div class="col-sm-12">
                                <button class="cmn--btn" type="submit">
                                    @langg('Login')
                                    <span class="round-effect">
                                        <i class="fas fa-long-arrow-alt-right"></i>
                                    </span>
                                </button>
                            </div>
                            <div class="col-sm-12">
                                @langg('Not Registered Yet ?') <a href="{{route('user.register')}}" class="text--base">@langg('Create an
                                    Account')</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="accounts-right">
                    <div class="section-header text-center text-white mb-0">
                        <h3 class="section-header__title">@langg('Don\'t have an account ?')</h3>
                        <a href="{{route('user.register')}}" class="cmn--btn">@langg('Create New Account') <span class="round-effect">
                                <i class="fas fa-long-arrow-alt-right"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

