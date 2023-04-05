@extends('layouts.user')

@section('title')
   @langg('Two Step Authentication')
@endsection


@section('content')

       <div class="container pt-100 pb-100">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                   
                    <div class="card-body">
                        <form action="" method="POST">
                            @csrf
                            <div class="form-group my-2">
                               <h6>@langg('Please check your phone number to get OTP code. Your phone number is : '.auth()->user()->phone)</h6>
                            </div>
                            <div class="form-group mb-2">
                                <label class="mb-1">@langg('OTP Code')</label>
                                <input class="form-control" type="text" name="code" required>
                            </div>
                            <div class="form-group d-flex justify-content-between">
                                <a href="{{route('user.two.step.resend')}}" class="text-left">@langg('Didn\'t get code? Resend.')</a>
                               <button type="submit" class="cmn--btn">@langg('Submit')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
       </div>

@endsection