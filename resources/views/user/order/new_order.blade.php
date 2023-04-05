@extends('layouts.user')
@section('title')
    @langg('New Order')
@endsection

@section('content')
<section class="user-panel pt-100 pb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="profile--card">
                    <form action="" method="POST">
                        @csrf
                        <div class="row gy-3">
                            <div class="col-12">
                                <label for="plan" class="form-label">@langg('Select Category') <sup class="text-danger">*</sup></label>
                                <select name="category_id" id="category" class="form-control form--control bg--body">
                                    <option value="">@langg('Select Category')</option>
                                    @foreach ($categories as $item)
                                      <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="plan" class="form-label">@langg('Select Service') <sup class="text-danger">*</sup></label>
                                <select name="service_id" id="service" class="form-control form--control bg--body" disabled>
                                </select>
                            </div>

                            <div class="col-12">
                                <label for="email" class="form-label">@langg('Your link') <sup class="text-danger">*</sup></label>
                                <input type="url" id="url" name="link" class="form-control form--control bg--body" placeholder="https://yourlink.com" required>
                            </div>

                            <div class="col-sm-6">
                                <label for="email" class="form-label">@langg('Order Quantity') <sup class="text-danger">*</sup></label>
                                <input type="number" placeholder="e.g : 200"  name="qty" class="form-control form--control bg--body qty" disabled required>
                            </div>

                            <div class="col-sm-6">
                                <label for="email" class="form-label">@langg('Price')</label>
                                <div class="input-group">
                                    <input type="text" readonly class="form-control form--control bg--body price">
                                    <span class="input-group-text">{{$gs->curr_code}}</span>
                                </div>
                            </div>

                            
                            <div class="col-12">
                                <h6 class="mt-4">@langg('Service Details')</h6>
                                <ul class="list-group mb-3 mt-3 list--group">
                                    <li class="list-group-item">
                                        <span class="title">@langg('Service Name') : </span>
                                        <div class="desc service_name"></div>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="title">@langg('Min Amount') : </span>
                                        <div class="desc min"></div>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="title">@langg('Max Amount') : </span>
                                        <div class="desc max"></div>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="title">@langg('Price/1k') : </span>
                                        <div class="desc price_per"></div>
                                    </li>
                                    <li class="list-group-item">
                                        <textarea  class="description form-control" disabled rows="10" placeholder="@lang('Description')"></textarea>
                                    </li>
                                </ul>
                                
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="cmn--btn w-100">@langg('Place Order') <i class="fas fa-long-arrow-alt-right"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@push('style')
<link rel="stylesheet" href="{{asset('assets/admin/css/select2.min.css')}}">
@endpush

@push('script')
<script src="{{asset('assets/admin/js/select2.min.js')}}"></script>
<script>
    'use strict';
    $('#category').select2();
    $('#service').select2();

    $('#category').on('change', function(){
        var category_id = $(this).val();
        if(category_id == ''){
            $('#service').attr('disabled', true);
            $('#service').html('');
            return false;
        } 
        $.ajax({
            url: "{{route('user.order.category.service')}}",
            type: "POST",
            data: {
                category_id: category_id,
                _token: '{{csrf_token()}}'
            },
            success: function(data){
                $('#service').html(data);
                $('#service').removeAttr('disabled');
            }
        });
    });

    var mainPrice = 0;
    $('#service').on('change', function(){
        var service_id = $(this).val();
        if(service_id == ''){
            $('.qty').attr('disabled', true);
            return false;
        } 
        $.ajax({
            url: "{{route('user.order.service.detail')}}",
            type: "POST",
            data: {
                service_id: service_id,
                _token: '{{csrf_token()}}'
            },
            success: function(data){
                $('.service_name').text(data.title);
                $('.min').text(data.min_amount);
                $('.max').text(data.max_amount);
                $('.price_per').text(data.price+' '+'{{$gs->curr_code}}');
                $('.description').val(data.description);
                mainPrice = data.price;
                $('.qty').removeAttr('disabled');
            }
        });
    });

    $('.qty').on('input keyup', function(){
        var qty = parseFloat($(this).val());
        isNaN(qty) ? qty = 0 : '';
        var total = (qty * parseFloat(mainPrice))/1000;
        $('.price').val(total);
    });
</script>
@endpush