@extends('layouts.user')

@section('title')
    @langg('Deposit')
@endsection

@section('breadcrumb')
@langg('Deposit')
@endsection

@section('content')
<section class="user-panel pt-100 pb-100">
   <div class="container">
    <div class="row mb-5">
        <div class="col-12">
            <div class="card">
            <div class="card-body">
                <form action="{{route('user.deposit.submit')}}" id="form" method="post">
                  @csrf
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="form-label">@langg('Amount : ')  </div>
                            <div class="input-group">
                                <input type="text" name="amount" id="amount" class="form-control shadow-none"  required>
                                <select class="form-control currency" name="currency">
                                    <option value="" selected>@langg('Select Currency')</option>
                                    @foreach ($currencies as $item)
                                        <option value="{{$item->id}}" data-code="{{$item->code}}"  data-rate="{{$item->rate}}">{{ $item->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <code>@langg('Amount will be converted to the default currency of this system : '.$gs->curr_code)</code>
                        </div>

                        <input type="hidden" name="curr_code">
                        <div class="col-md-6">
                            <div class="form-label">@langg('Select Gateway')</div>
                            <select class="form-control method shadow-none" name="gateway" disabled>
                                <option value="" selected>@langg('Select')</option>
                               
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="form-label">&nbsp;</div>
                            <a href="#" class="cmn--btn w-100 confirm">
                                @langg('Confirm')
                            </a>
                        </div>

                        <div class="modal modal-blur fade" id="modal-success" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog  modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="my-modal-title">@langg('Deposit Preview')</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center py-4">
                                    <ul class="list-group mt-2">
                                        <li class="list-group-item d-flex justify-content-between font-weight-bold">@lang('Amount : ')<span class="d_amount"></span></li>

                                        <li class="list-group-item d-flex justify-content-between font-weight-bold">@lang('Total Charge : ')<span class="charge text--danger"></span></li>
                                  
                                        <li class="list-group-item d-flex justify-content-between font-weight-bold">@lang('Total Amount : ')<span class="total_amount text--primary"></span></li>

                                        <li class="list-group-item d-flex justify-content-between font-weight-bold">@lang('Rate 1 '.$gs->curr_code.' :')<span class="rate text--info"></span></li>

                                        <li class="list-group-item d-flex justify-content-between font-weight-bold">@lang('You will get : ')<span class="will_get text--success"></span></li>
                      
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                <div class="w-100">
                                    <div class="row">
                                    <div class="col">
                                        <a href="#" class="btn btn-dark w-100" data-bs-dismiss="modal">
                                        @langg('Cancel')
                                        </a>
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary w-100 confirm">
                                           @langg('Confirm')
                                        </button>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </form>
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

        $('.method').on('change',function () { 
            var amount = parseFloat($('#amount').val())
            var selected = $('.method option:selected')

            if(selected.val() == '' ){
                $('.info').addClass('d-none')
                return false;
            }
            if($('#amount').val() == ''){
                toast('error','@langg('Please provide the amount first.')')
                return false;
            }
        })

        $('.confirm').on('click',function () { 
            var method = $('.method option:selected')
            var currency = $('.currency option:selected')

            if(method.val() == ''){
                $('.info').addClass('d-none')
                toast('error','@langg('Please select the payment method first.')')
                return false;
            }
            if($('#amount').val() == ''){
                toast('error','@langg('Please provide the amount first.')')
                return false;
            }
            if(currency.val() == ''){
                toast('error','@langg('Please select the currency first.')')
                return false;
            }

            $('.d_amount').text($('#amount').val() + ' ' + currency.data('code'))
            var totalCharge;
            var totalamount;

            if(method.data('type') == 'manual'){
               totalCharge = parseFloat(method.data('fix')) + (parseFloat($('#amount').val()) * (method.data('percent')/100))
               $('.charge').text(totalCharge.toFixed(3)+' '+currency.data('code'))
               totalamount = parseFloat($('#amount').val()) + totalCharge
               $('.total_amount').text(totalamount.toFixed(3)+' '+currency.data('code'))
            }else{
                $('.charge').text(0+' '+currency.data('code'))
                totalamount = parseFloat($('#amount').val())
                $('.total_amount').text(totalamount.toFixed(3)+' '+currency.data('code'))
            }

            var will_get = totalamount/parseFloat(currency.data('rate'))
            $('.rate').text(parseFloat(currency.data('rate')).toFixed(3)+' '+currency.data('code'))
            $('.will_get').text(will_get.toFixed(4)+' '+'{{$gs->curr_code}}')

            $('#modal-success').modal('show')
        })

        $('.currency').on('change',function () { 

            if($('#amount').val() == ''){
                toast('error','@lang('Please provide the amount first.')')
                return false;
            }

            $.get('{{route('user.gateway.methods')}}',{currency:$('.currency option:selected').val()},function (res) { 
                if(res == 'empty'){
                    toast('error','@lang('No payment method found associate with this currency.')')
                    $('.method').attr('disabled',true)
                    return false;
                }

                var html = `<option value="">@lang('Select')</option>`;
                $.each(res, function (i, val) { 
                    html += `<option value="${val.id}" data-type="${val.type}" data-fix="${val.fixed_charge}" data-percent="${val.percent_charge}">${val.name}</option>`
                });
                // $('input[name=curr_code]').val( $('.currency option:selected').data('code'))
                $('.method').attr('disabled',false)
                $('.method').html(html)
            })
})
   </script>
@endpush