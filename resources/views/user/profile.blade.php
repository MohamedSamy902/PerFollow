@extends('layouts.user')

@section('title')
   @langg('Profile Settings')
@endsection


@section('content')
    <div class="container pt-100 pb-100">
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row ">
                <div class="col-md-4">
                    <div class="d-flex flex-wrap justify-content-center">
                        <div class="profile--contain-img rounded">
                            <img src="{{getPhoto($user->photo)}}" id="profile-img-show" class="card-img-top imageShow">
                            <label for="profile" class="text--base change-profile">
                                <i class="fas fa-pen"></i>
                            </label>
                            <input id="profile" type="file" class="form-control-file imageUpload file-type mb-1" name="photo" hidden>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                   <div class="card">
                       <div class="card-body p-xl-4">
                            <div class="row g-3">
                                <div class="form-group col-md-6">
                                    <label class="mb-2">@langg('Name')</label>
                                    <input class="form-control" type="text" name="name" value="{{$user->name}}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="mb-2">@langg('Email')</label>
                                    <input class="form-control" type="email" value="{{$user->email}}" disabled>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="mb-2">@langg('Username')</label>
                                    <input class="form-control" type="email" value="{{$user->username}}" disabled>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="mb-2">@langg('Phone')</label>
                                    <input class="form-control" name="phone" type="text" value="{{$user->phone}}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="mb-2">@langg('Country')</label>
                                    <input class="form-control" type="text" value="{{$user->country}}" disabled>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="mb-2">@langg('City')</label>
                                    <input class="form-control" type="text" name="city" value="{{$user->city}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="mb-2">@langg('Zip')</label>
                                    <input class="form-control" type="text" name="zip" value="{{$user->zip}}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="mb-2">@langg('Address')</label>
                                    <input class="form-control" type="text" name="address" value="{{$user->address}}">
                                </div>
                                <div class="form-group col-md-12 mt-3 text-end">
                                    <button type="submit" class="cmn--btn">@langg('Update now')</button>
                                </div>
                        </div>
                        </div>
                   </div>
                </div>
            </div>
        </form>
       
       
    </div>
@endsection

@push('script')
    <script>
        'use strict';
        function imageUpload(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#profile-img-show').attr('src',e.target.result)
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(".imageUpload").on('change', function () {
            imageUpload(this);
        });
    </script>
@endpush