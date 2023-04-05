@extends('layouts.auth')

@section('title')
   @langg('Verify Email')
@endsection

@section('content')

    <section class="accounts-section">
        <div class="container">
            <div class="accounts-inner">
                <div class="accounts-inner__wrapper bg--section">
                    <div class="accounts-left">
                        <div class="accounts-left-content">
                            <div class="section-header">
                                <h3 class="section-header__title mt-0">@lang('Email Verify Code')</h3>
                            </div>
                            <form class="row gy-4" action="" method="post"> 
                                @csrf
                                <div class="col-sm-12">
                                    <label for="username" class="form-label">@langg('Verification Code')</label>
                                    <input type="text" name="code" class="form-control" id="email"
                                    placeholder="@langg('Reset Code')" value="{{old('code')}}" required>
                                </div>
                                
                                <div class="col-sm-12">
                                    <button class="cmn--btn" type="submit">
                                        @langg('Verify code')
                                        <span class="round-effect">
                                            <i class="fas fa-long-arrow-alt-right"></i>
                                        </span>
                                    </button>
                                </div>
                                <div class="col-sm-12">
                                    @langg('Take me to login page.') <a href="{{url('/')}}" class="text--base">@langg('Take me to home page.')</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="accounts-right">
                        <div class="section-header text-center text-white mb-0">
                            <h3 class="section-header__title">@langg('Enter the verification code that we sent to your email.')</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
