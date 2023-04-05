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
                            <h3 class="section-header__title mt-0">@lang('Please verify the reset code')</h3>
                        </div>
                        <form class="row gy-4" action="" method="post"> 
                            @csrf
                            <div class="col-sm-12">
                                <label for="username" class="form-label">@langg('Reset Code')</label>
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
                                @langg('Take me to login page.') <a href="{{route('user.login')}}" class="text--base">@langg('Login')</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="accounts-right">
                    <div class="section-header text-center text-white mb-0">
                        <h3 class="section-header__title">@langg('Please check your email for reset code.')</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
