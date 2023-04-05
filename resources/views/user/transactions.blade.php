@extends('layouts.user')

@section('title')
   @langg('Transactions')
@endsection

@section('breadcrumb')
  @langg('Transactions')
@endsection

@push('extra')
   <form action="" class="row g-3 justify-content-end">
    <div class="col-sm-6 col-md-4">
      <select class="form-control shadow-none" onChange="window.location.href=this.value">
        <option value="{{filter('remark','')}}">@langg('All Remark')</option>
            <option value="{{filter('remark','transfer_money')}}" {{request('remark') == 'transfer_money' ? 'selected':''}}>@langg('Transfer Money')</option>
          
            <option value="{{filter('remark','request_money')}}" {{request('remark') == 'request_money' ? 'selected':''}}>@langg('Request Money')</option>
            
            <option value="{{filter('remark','money_exchange')}}" {{request('remark') == 'money_exchange' ? 'selected':''}}>@langg('Money Exchange')</option>
            
            <option value="{{filter('remark','invoice_payment')}}" {{request('remark') == 'invoice_payment' ? 'selected':''}}>@langg('Invoice Payment')</option>
          
            <option value="{{filter('remark','merchant_payment')}}" {{request('remark') == 'merchant_payment' ? 'selected':''}}>@langg('Merchant Payment')</option>
          
            <option value="{{filter('remark','merchant_api_payment')}}" {{request('remark') ==  'merchant_api_payment' ? 'selected':''}}>@langg('Merchant API Payment')</option>
          
            <option value="{{filter('remark','escrow_return')}}" {{request('remark') == 'escrow_return' ? 'selected':''}}>@langg('Escrow Return')</option>
          
            <option value="{{filter('remark','make_escrow')}}" {{request('remark') == 'make_escrow' ? 'selected':''}}>@langg('Make Escrow')</option>
  
            <option value="{{filter('remark','withdraw_money')}}" {{request('remark') == 'withdraw_money' ? 'selected':''}}>@langg('Withdraw Money')</option>

            <option value="{{filter('remark','withdraw_reject')}}" {{request('remark') == 'withdraw_reject' ? 'selected':''}}>@langg('Withdraw Reject')</option>
  
            <option value="{{filter('remark','redeem_voucher')}}" {{request('remark') == 'redeem_voucher' ? 'selected':''}}>@langg('Redeem Voucher')</option>
  
            <option value="{{filter('remark','create_voucher')}}" {{request('remark') == 'create_voucher' ? 'selected':''}}>@langg('Create Voucher')</option>

            <option value="{{filter('remark','deposit')}}" {{request('remark') == 'deposit' ? 'selected':''}}>@langg('Deposit')</option>
      </select>
    </div>
    <div class="col-sm-6 col-md-4">
      <div class="input-group">
          <input type="text" class="form-control shadow-none" value="{{$search ?? ''}}" name="search" placeholder="@langg('Transaction ID')">
              <button class="input-group-text btn btn-primary text-white" id="my-addon"><i class="fas fa-search"></i>
              </button>
      </div>
  </div>
   </form>
@endpush

@section('content')
<section class="user-panel pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                  <div class="card-header bg-white py-3">
                    <form action="" class="w-100">
                      <div class="row g-3 justify-content-end">
                        <div class="col-sm-6 col-md-4">
                          <select  class="form-control me-2 shadow-none" onChange="window.location.href=this.value">
                            <option value="{{filter('remark','')}}">@langg('All Remark')</option>
                                <option value="{{filter('remark','transfer_balance')}}" {{request('remark') == 'transfer_balance' ? 'selected':''}}>@langg('Transfer Balance')</option>
                                <option value="{{filter('remark','deposit')}}" {{request('remark') == 'deposit' ? 'selected':''}}>@langg('Deposit')</option>
                                <option value="{{filter('remark','order_placed')}}" {{request('remark') == 'order_placed' ? 'selected':''}}>@langg('Order Placed')</option>

                                <option value="{{filter('remark','deposit_referral_bonus')}}" {{request('remark') == 'deposit_referral_bonus' ? 'selected':''}}>@langg('Deposit Referral Bonus')</option>

                                <option value="{{filter('remark','register_referral_bonus')}}" {{request('remark') == 'register_referral_bonus' ? 'selected':''}}>@langg('Register Referral Bonus')</option>
                                <option value="{{filter('remark','add_balance')}}" {{request('remark') == 'add_balance' ? 'selected':''}}>@langg('Add Balance By System')</option>
                              
                                <option value="{{filter('remark','subtract_balance')}}" {{request('remark') == 'subtract_balance' ? 'selected':''}}>@langg('Subtract Balance By System')</option>
                          </select>
                        </div>
                        <div class="col-sm-6 col-md-4">
                          <div class="input-group">
                              <input type="text" class="form-control shadow-none" value="{{$search ?? ''}}" name="search" placeholder="@langg('Transaction ID')">
                                  <button class="input-group-text btn btn-primary text-white" id="my-addon"><i class="fas fa-search"></i>
                                  </button>
                          </div>
                      </div>
                    </div>
                     </form>
                  </div>
                 
                  <div class="table-responsive">
                    <table class="table bg--body">
                      <thead>
                        <tr>
                          <th>@langg('Date')</th>
                          <th>@langg('Transaction ID')</th>
                          <th>@langg('Remark')</th>
                          <th>@langg('Amount')</th>
                          <th>@langg('Details')</th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($transactions as $item)
                          <tr>
                            <td data-label="@langg('Date')">{{dateFormat($item->created_at,'d-M-Y')}}</td>
                            <td data-label="@langg('Transaction ID')">
                              {{translate($item->trnx)}}
                            </td>
                            <td data-label="@langg('Remark')">
                              <span class="badge bg-dark">{{ucwords(str_replace('_',' ',$item->remark))}}</span>
                            </td>
                            <td data-label="@langg('Amount')">
                                <span class="{{$item->type == '+' ? 'text-success':'text-danger'}}">{{$item->type}} {{round($item->amount,2)}} {{$gs->curr_code}}</span> 
                            </td>
                            <td data-label="@langg('Details')">
                                <button class="btn btn-primary btn-sm details" data-data="{{$item}}">@langg('Details')</button>
                            </td>
                          </tr>
                        @empty
                        <tr><td class="text-center" colspan="12">@langg('No data found!')</td></tr>
                        @endforelse
                      </tbody>
                    </table>
                  </div>
                  @if ($transactions->hasPages())
                      <div class="card-footer bg-white">
                          {{$transactions->links()}}
                      </div>
                  @endif
                </div>
            </div>
        </div>
    </div>
</section>
    <div class="modal modal-blur fade" id="modal-success" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-status bg-primary"></div>
            <div class="modal-body text-center py-4">
            <i  class="fas fa-info-circle fa-3x text-primary mb-2"></i>
            <h3>@langg('Transaction Details')</h3>
            <p class="trx_details mt-2"></p>
            <ul class="list-group mt-2">
               
            </ul>
            </div>
            <div class="modal-footer">
            <div class="w-100">
                <div class="row">
                <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                    @langg('Close')
                    </a></div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
      'use strict';
   
      $('.details').on('click',function () { 
        var url = "{{url('user/transaction/details/')}}"+'/'+$(this).data('data').id
        $('.trx_details').text($(this).data('data').details)
        $.get(url,function (res) { 
          if(res == 'empty'){
            $('.list-group').html('<p>@langg('No details found!')</p>')
          }else{
            $('.list-group').html(res)
          }
          $('#modal-success').modal('show')
        })
      })
    </script>
@endpush