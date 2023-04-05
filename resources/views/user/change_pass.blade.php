@extends('layouts.user')

@section('title')
    @lang('Change Password')
@endsection

@section('content')
<div class="container pt-100 pb-100">
    <form action="" method="POST" class="mt-3">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body row">
                    <div class="form-group col-md-12 my-2">
                        <h3>@langg('Change Password')</h3>
                    </div>
                        <div class="form-group col-md-12 mb-2">
                            <label class="mb-2">@langg('Old Password')</label>
                            <input class="form-control" type="password" name="old_pass" required>
                        </div>
                        <div class="form-group col-md-12 mb-2">
                            <label class="mb-2">@langg('New Password')</label>
                            <input class="form-control" type="password" name="password" required>
                        </div>
                        <div class="form-group col-md-12 mb-2">
                            <label class="mb-2">@langg('Confirm Password')</label>
                            <input class="form-control" type="password" name="password_confirmation" required>
                        </div>
                        
                        <div class="form-group col-md-12 mb-2 text-end">
                            <button type="submit" class="cmn--btn">@langg('Change')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form> 
</div>
@endsection