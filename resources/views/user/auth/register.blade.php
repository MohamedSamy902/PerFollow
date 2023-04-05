@extends('layouts.frontend')

@section('title')
   @langg('User Register')
@endsection


@section('content')

<section class="accounts-section">
    <div class="container">
        <div class="accounts-inner">
            <div class="accounts-inner__wrapper bg--section">
                <div class="accounts-left">
                    <div class="accounts-left-content mw-100">
                        <div class="section-header">
                            <h3 class="section-header__title">@langg('Register in') {{$gs->title}}</h3>
                        </div>
                        <form class="row gy-3" action="" method="POST">
                            @csrf
                            @if (session('referral'))
                            <div class="col-md-12">
                                <label for="name" class="form-label">@langg('Referred By')</label>
                                <input type="text" class="form-control" disabled  value="{{session('referral')}}">
                            </div>
                                
                            @endif
                            <div class="col-md-6">
                                <label for="name" class="form-label">@langg('Your Name')</label>
                                <input type="text" class="form-control" name="name" placeholder="@langg('Enter name')" required value="{{old('name')}}">
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label">@langg('Username')</label>
                                <input type="text" class="form-control" name="username" placeholder="@langg('Enter Username')" required value="{{old('username')}}">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">@langg('Your Email')</label>
                                <input type="email" class="form-control" name="email" placeholder="@langg('Enter email')" required value="{{old('email')}}">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label">@langg('Country')</label>
                                <select name="country" class="form-control country" required>
                                    <option value="">@langg('Select')</option>
                                    @foreach ($countries as $item)
                                        <option value="{{$item->name}}" data-dial_code="{{$item->dial_code}}" {{@$info->geoplugin_countryCode == $item->code ? 'selected':''}}>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
        
                            <div class="col-sm-6 form-group">
                                 <label class="form-label">@langg('Phone No.')</label>
                                <input type="hidden" name="dial_code">
                                <div class="input-group">
                                    <span class="input-group-text d_code"></span>
                                    <input type="text" name="phone"  class="form-control" placeholder="@langg('Phone No.')" required value="{{old('phone')}}">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="account-type" class="form-label">@langg('Address')</label>
                                <input type="text" name="address" value="{{old('address')}}" class="form-control" placeholder="@langg('Address')" required>
                            </div>

                            <div class="col-sm-6 form-group">
                                <label class="form-label">@langg('Password')</label>
                                <input type="password" name="password" class="form-control"  placeholder="@langg('Password')"  autocomplete="off" required>
                                
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label">@langg('Confirm Password')</label>
                                <input type="password" name="password_confirmation" class="form-control"  placeholder="@langg('Confirm Password')"  autocomplete="off">
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
                                    @langg('Register')
                                    <span class="round-effect">
                                        <i class="fas fa-long-arrow-alt-right"></i>
                                    </span>
                                </button>
                            </div>
                            <div class="col-sm-12">
                                @langg('Already have an account ?') <a href="{{route('user.login')}}" class="text--base">@langg('Login')</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="accounts-right">
                    <div class="section-header text-center text-white mb-0">
                        <h3 class="section-header__title">@langg('Already have an account ?')</h3>
                        <a href="{{route('user.login')}}" class="cmn--btn">
                            @langg('Login')
                            <span class="round-effect">
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

@push('script')
    <script>
      'use strict';
      function auto() {
        var code = $('.country option:selected').data('dial_code')
        $('.d_code').text(code)
        $('input[name=dial_code]').val(code)
      }
      auto();
      $('.country').on('change',function () {
        auto();
      })

    </script>
@endpush
