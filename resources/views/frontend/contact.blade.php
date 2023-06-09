@extends('layouts.frontend')

@section('title')
    @langg('Contact Us')
@endsection

@section('content')
<section class="contact-section pt-100 pb-100">
    <div class="container">
        <div class="row flex-wrap-reverse">
            <div class="col-lg-6 pe-xl-5 gy-5">
                    <form class="contact-form row g-4" action="" method="POST">
                        @csrf
                        <div class="col-sm-6 form-group">
                          
                            <input type="text" name="name" class="form-control form--control bg--section" id="name"
                                placeholder="@langg('Your Name')" required value="{{old('name')}}">
                        </div>
                        <div class="col-sm-6 form-group">
              
                            <input type="text" name="email" class="form-control form--control bg--section" id="email"
                                placeholder="@langg('Your Email Address')" required value="{{old('email')}}">
                        </div>
                        <div class="col-sm-12 form-group">
                     
                            <input type="text" name="subject" class="form-control form--control bg--section" id="subject"
                                placeholder="@langg('Subject')" required value="{{old('subject')}}">
                        </div>
                        <div class="col-sm-12 form-group">
                           
                            <textarea id="message" name="message" class="form-control form--control bg--section"
                                placeholder="@langg('Your Message')" required>{{old('subject')}}</textarea>
                        </div>

                        @if ($gs->recaptcha)
                        <div class="col-sm-12 form-group">
                            {!! NoCaptcha::display() !!}
                            {!! NoCaptcha::renderJs() !!}
                            @error('g-recaptcha-response')
                            <p class="my-2 text--danger">{{$message}}</p>
                            @enderror
                        </div>
                        @endif

                       
                        <div class="col-xl-12 form-group">
                            <button type="submit" class="cmn--btn">@langg('Send Message')</button>
                        </div>
                    </form>
                
            </div>
            <div class="col-lg-6">
                <div class="section-title mb-4 pb-3">
                    <h6 class="section-header__subtitle">@lang(@$contact->content->title)</h6>
                    <h2 class="section-header__title">@lang(@$contact->content->heading)</h2>
                    <p>
                       @lang(@$contact->content->sub_heading)
                    </p>
                </div>
                <div class="contact-content">
                    <div class="contact__item">
                        <div class="contact__item-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="contact__item-cont">
                            <h5 class="contact__item-title">@langg('Phone')</h5>
                            <a href="Tel:{{@$contact->content->phone}}" class="text--base">{{@$contact->content->phone}}</a>
                        </div>
                    </div>
                    <div class="contact__item">
                        <div class="contact__item-icon">
                            <i class="far fa-envelope"></i>
                        </div>
                        <div class="contact__item-cont">
                            <h5 class="contact__item-title">@langg('Email')</h5>
                            <a href="email:{{@$contact->content->email}}" class="text--base">{{@$contact->content->email}}</a>
                        </div>
                    </div>
                    <div class="contact__item">
                        <div class="contact__item-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact__item-cont">
                            <h5 class="contact__item-title">@langg('Address')</h5>
                            <span class="text--base">{{@$contact->content->address}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection