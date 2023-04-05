@extends('layouts.admin')

@section('title')
   @langg('Manage Referral')
@endsection

@section('breadcrumb')
 <section class="section">
    <div class="section-header">
        <h1>@langg('Manage Referral')</h1>
    </div>
</section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="" method="POST" class="row">
                        @csrf
                        <div class="form-group col-md-6">
                            <label>@langg('Referral System Status')</label>
                            <select name="status" class="form-control">
                                <option value="1" {{$referral->status == 1 ? 'selected':''}}>@langg('Enable')</option>
                                <option value="0" {{$referral->status == 0 ? 'selected':''}}>@langg('Disable')</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>@langg('Referral Type')</label>
                            <select name="type" class="form-control type">
                                <option value="deposit" {{$referral->type == 'deposit' ? 'selected':''}}>@langg('Deposit')</option>
                                <option value="register" {{$referral->type == 'register' ? 'selected':''}}>@langg('Register')</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label>@langg('Bonus Amount')</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="bonus_amount" placeholder="@lang('e.g : 10')" required value="{{old('bonus_amount',$referral->bonus_amount)}}">
                                <div class="input-group-append">
                                    <span class="input-group-text symbol">{{$referral->type == 'deposit' ? '%':$gs->curr_code}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12 bonus_count">
                            @if ($referral->type == 'deposit')
                            <label>@langg('How many times referrer get bonus ?')</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="bonus_count" placeholder="@lang('e.g : 5')" value="{{$referral->bonus_count}}" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">@langg('times')</span>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="form-group col-md-12 get_bonus">
                            @if ($referral->type == 'register')
                            <label>@langg('Who gets bonus ?')</label>
                            <select name="get_bonus" class="form-control">
                                <option value="referrar" {{$referral->get_bonus =='referrar'?'selected':''}}>@langg('Only Referrer')</option>
                                <option value="both" {{$referral->get_bonus =='both' ? 'selected':''}}>@langg('Both')</option>
                            </select>
                            @endif
                        </div>
                        <div class="form-group col-md-12 text-right">
                           <button class="btn btn-primary" type="submit">@langg('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@push('script')
    <script>
        'use strict';
        $('.type').on('change',function () { 
            if($(this).val() == 'deposit'){
                $('.bonus_count').html(`<label>@langg('How many times referrer get bonus ?')</label>
                            <div class="input-group">
                                <input type="number" class="form-control" name="bonus_count" placeholder="@lang('e.g : 5')" value="{{$referral->bonus_count}}" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">@langg('times')</span>
                                </div>
                            </div>`);
                            $('.get_bonus').html('')
                            $('.symbol').text('%')
            }else{
                $('.bonus_count').html('');
                $('.get_bonus').html(` <label>@langg('Who gets bonus ?')</label>
                            <select name="get_bonus" class="form-control">
                                <option value="referrar" {{$referral->get_bonus =='referrar'?'selected':''}}>@langg('Only Referrer')</option>
                                <option value="both" {{$referral->get_bonus =='both' ? 'selected':''}}>@langg('Both')</option>
                            </select>`);
                $('.symbol').text('{{$gs->curr_code}}')
            }
        });
    </script>
@endpush