@extends('layouts.frontend')

@section('title')
    @langg('Reset Password')
@endsection


@section('content')
<section class="accounts-section">
    <div class="container">
        <div class="accounts-inner">
            <div class="accounts-inner__wrapper bg--section">
                <div class="accounts-left">
                    <div class="accounts-left-content">
                        <div class="section-header">
                            <h3 class="section-header__title mt-0">@lang('Reset Password')</h3>
                        </div>
                        <form class="row gy-4" method="POST" action=""> 
                            @csrf
                            <div class="col-sm-12 form-group">
                                <label class="form-label" for="email">@langg('Email')</label>
                                <input type="text" value="{{session('email')}}" class="form-control" id="email" disabled>
                            </div>
                            <div class="col-sm-12 form-group">
                                <label class="form-label" for="email">@langg('Password')</label>
                                <input type="password" name="password" class="form-control" id="email"
                                       placeholder="@langg('Password')"  required>
                            </div>
                            <div class="col-sm-12 form-group">
                                <label class="form-label" for="email">@langg('Confirm Password')</label>
                                <input type="password" name="password_confirmation" class="form-control" id="email"
                                       placeholder="@langg('Confirm Password')"  required>
                            </div>
                            <div class="col-sm-12">
                                <button class="cmn--btn" type="submit">
                                    @langg('Reset')
                                    <span class="round-effect">
                                        <i class="fas fa-long-arrow-alt-right"></i>
                                    </span>
                                </button>
                            </div>
                            <div class="col-sm-12">
                                @langg('Take me to login page.') <a href="{{route('user.login')}}" class="text--base">@langg('Login')</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="accounts-right">
                    <div class="section-header text-center text-white mb-0">
                        <h3 class="section-header__title">@langg('Renew your account password')</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
