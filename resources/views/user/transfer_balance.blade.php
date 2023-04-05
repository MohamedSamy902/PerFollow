@extends('layouts.user')

@section('title')
    @lang('Transfer Balance')
@endsection


@section('content')
<section class="user-panel pt-100 pb-100">
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
            <div class="card-body">
                <form action="" id="form" method="post">
                  @csrf
                    <div class="row">
                      
                        <div class="form-group col-md-6">
                            <div class="form-label">@lang('Receiver Email/Username') <span class="ms-2 check"></span></div>
                            <input type="text" name="receiver" id="receiver" class="form-control shadow-none receiver" required>
                        </div>
                     
                        <div class="form-group col-md-6">
                            <div class="form-label ">@lang('Amount : ') <code class="limit">@lang('min : '.round($gs->min_trans,2).' '.$gs->curr_code) -- @lang('max : '.round($gs->max_trans,2).' '.$gs->curr_code)</code> </div>
                            <input type="text" name="amount" id="amount" class="form-control shadow-none mb-2"  required>
                            <small class="text-danger charge"></small>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="form-label">&nbsp;</div>
                            <a href="#" class="cmn--btn w-100 transfer">
                                @lang('Transfer')
                            </a>
                        </div>


                        <div class="modal modal-blur fade" id="modal-success" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-body text-center py-4">
                                        <ul class="list-group mt-2">
                                            <li class="list-group-item d-flex justify-content-between">@lang('Transfer Amount')<span class="amount"></span></li>
                                            <li class="list-group-item d-flex justify-content-between">@lang('Total Charge')<span class="charge"></span></li>
                                            <li class="list-group-item d-flex justify-content-between">@lang('Total Amount')<span class="total_amount"></span></li>
                                        </ul>
                                </div>
                                <div class="modal-footer">
                                    <div class="w-100">
                                        <div class="row">
                                        <div class="col"><a href="#" class="btn btn-dark w-100" data-bs-dismiss="modal">
                                            @lang('Cancel')
                                            </a></div>
                                        <div class="col">
                                            <button type="button" class="btn btn-primary w-100 confirm">
                                            @lang('Confirm')
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
        $('.receiver').on('focusout',function () { 
            var url   = '{{ route('user.check.receiver') }}';
            var value = $(this).val();
            var token = '{{ csrf_token() }}';
            var data  = {receiver:value,_token:token}
           
            $.post(url,data,function(res) {
                if(res.self){
                    if($('.check').hasClass('text-success')){
                        $('.check').removeClass('text-success');
                    }
                    $('.check').addClass('text-danger').text(res.self);
                    $('.transfer').attr('disabled',true)
                    return false
                }
                if(res['data'] != null){
                    if($('.check').hasClass('text-danger')){
                        $('.check').removeClass('text-danger');
                    }
                    $('.check').text(`@lang('Valid receiver found.')`).addClass('text-success');
                    $('.transfer').attr('disabled',false)
                } else {
                    if($('.check').hasClass('text-success')){
                        $('.check').removeClass('text-success');
                    }
                    $('.check').text('@lang('Receiver not found.')').addClass('text-danger');
                    
                }
            });
        })

        $('.transfer').on('click',function () { 

            var amount = parseFloat($('#amount').val());

            if($('#receiver').val() == '' || amount == '' ){
                toast('error','@lang('Please fill up the required fields')')
                return false;
            }
            if($('#amount').val() < limit().minLimit || $('#amount').val() > limit().maxLimit){
                toast('error','@lang('Please follow the limit.')')
                return false;
            }

            $('#modal-success').find('.amount').text(amount +' '+"{{ $gs->curr_code }}");
            $('#modal-success').find('.charge').text(charge().final +' '+ "{{ $gs->curr_code }}")
            $('#modal-success').find('.total_amount').text((parseFloat(charge().final)+amount) +' '+"{{ $gs->curr_code }}")
            $('#modal-success').modal('show')
        })

        $('.confirm').on('click',function () { 
            $('#form').submit()
            $(this).attr('disabled',true)
        })

        function limit() { 

            var minimum = parseFloat('{{$gs->min_trans}}')
            var maximum = parseFloat('{{$gs->max_trans}}')

            return {'minLimit': minimum,'maxLimit': maximum};
        }

        function charge() { 
            var amount = $('#amount').val()

            var fixedCharge   = parseFloat('{{$gs->transfer_fix_charge}}')
            var percentCharge = parseFloat('{{$gs->transfer_percent_charge}}')

            var finalCharge =  fixedCharge + (amount * percentCharge)/100

            return {'final':finalCharge,'fixed':fixedCharge,'percent':percentCharge};

        }

        
    </script>
@endpush