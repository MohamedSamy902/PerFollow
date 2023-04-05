@extends('layouts.user')
@section('title')
    @langg('User Dashboard')
@endsection

@section('content')
<section class="user-panel pt-100 pb-100">
  <div class="container">
      <div class="dashboard--content-item">
          <div class="dashboard--wrapper">
              <div class="dashboard--width">
                  <div class="dashboard-card">
                      <div class="dashboard-card__header">
                          <div class="dashboard-card__header__icon">
                              <i class="fas fa-wallet"></i>
                          </div>
                          <div class="dashboard-card__header__cont">
                              <h4 class="name">{{number_format(auth()->user()->balance,2)}} {{$gs->curr_code}}</h4>
                              <div class="balance">@langg('Total Balance')</div>
                          </div>
                      </div>
                      
                  </div>
              </div>
              
              <div class="dashboard--width">
                  <div class="dashboard-card">
                      <div class="dashboard-card__header">
                          <div class="dashboard-card__header__icon">
                            <i class="fas fa-random"></i>
                          </div>
                          <div class="dashboard-card__header__cont">
                              <h4 class="name">{{number_format(\App\Models\Transaction::where([['user_id',auth()->id()],['remark','transfer_balance'],['type','-']])->sum('amount'),2)}} {{$gs->curr_code}}</h4>
                              <div class="balance">@langg('Total Balance Transfered')</div>
                          </div>
                      </div>
                      
                  </div>
              </div>
              <div class="dashboard--width">
                  <div class="dashboard-card">
                      <div class="dashboard-card__header">
                          <div class="dashboard-card__header__icon">
                            <i class="fas fa-money-check-alt"></i>
                          </div>
                          <div class="dashboard-card__header__cont">
                              <h4 class="name">{{number_format(\App\Models\Deposit::where('user_id',auth()->id())->sum('amount'),2)}} {{$gs->curr_code}}</h4>
                              <div class="balance">@langg('Total Deposit')</div>
                          </div>
                      </div>
                      
                  </div>
              </div>
              <div class="dashboard--width">
                  <div class="dashboard-card">
                      <div class="dashboard-card__header">
                          <div class="dashboard-card__header__icon">
                            <i class="fas fa-hands-helping"></i>
                          </div>
                          <div class="dashboard-card__header__cont">
                              <h4 class="name">{{\App\Models\User::where('referred_by',auth()->id())->count()}}</h4>
                              <div class="balance">@langg('Total Referral')</div>
                          </div>
                      </div>
                      
                  </div>
              </div>
              <div class="dashboard--width">
                <div class="dashboard-card">
                    <div class="dashboard-card__header">
                        <div class="dashboard-card__header__icon">
                          <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="dashboard-card__header__cont">
                            <h4 class="name">{{$data['total']}}</h4>
                            <div class="balance">@langg('Total Order')</div>
                        </div>
                    </div>
                    
                </div>
            </div>
              <div class="dashboard--width">
                <div class="dashboard-card">
                    <div class="dashboard-card__header">
                        <div class="dashboard-card__header__icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="dashboard-card__header__cont">
                            <h4 class="name">{{$data['completed']}}</h4>
                            <div class="balance">@langg('Order Compeleted')</div>
                        </div>
                    </div>
                    
                </div>
            </div>
              <div class="dashboard--width">
                <div class="dashboard-card">
                    <div class="dashboard-card__header">
                        <div class="dashboard-card__header__icon">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <div class="dashboard-card__header__cont">
                            <h4 class="name">{{$data['processing']}}</h4>
                            <div class="balance">@langg('Order Processing')</div>
                        </div>
                    </div>
                    
                </div>
            </div>
              <div class="dashboard--width">
                <div class="dashboard-card">
                    <div class="dashboard-card__header">
                        <div class="dashboard-card__header__icon">
                            <i class="fas fa-spinner"></i>
                        </div>
                        <div class="dashboard-card__header__cont">
                            <h4 class="name">{{$data['in_progress']}}</h4>
                            <div class="balance">@langg('Order In Progress')</div>
                        </div>
                    </div>
                    
                </div>
            </div>
              <div class="dashboard--width">
                <div class="dashboard-card">
                    <div class="dashboard-card__header">
                        <div class="dashboard-card__header__icon">
                            <i class="fas fa-hourglass-end"></i>
                        </div>
                        <div class="dashboard-card__header__cont">
                            <h4 class="name">{{$data['in_progress']}}</h4>
                            <div class="balance">@langg('Order Pending')</div>
                        </div>
                    </div>
                    
                </div>
            </div>
              <div class="dashboard--width">
                <div class="dashboard-card">
                    <div class="dashboard-card__header">
                        <div class="dashboard-card__header__icon">
                            <i class="fas fa-adjust"></i>
                        </div>
                        <div class="dashboard-card__header__cont">
                            <h4 class="name">{{$data['partial']}}</h4>
                            <div class="balance">@langg('Order Partial')</div>
                        </div>
                    </div>
                    
                </div>
            </div>
              <div class="dashboard--width">
                <div class="dashboard-card">
                    <div class="dashboard-card__header">
                        <div class="dashboard-card__header__icon">
                            <i class="fas fa-ban"></i>
                        </div>
                        <div class="dashboard-card__header__cont">
                            <h4 class="name">{{$data['canceled']}}</h4>
                            <div class="balance">@langg('Order Canceled')</div>
                        </div>
                    </div>
                    
                </div>
            </div>
              <div class="dashboard--width">
                <div class="dashboard-card">
                    <div class="dashboard-card__header">
                        <div class="dashboard-card__header__icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <div class="dashboard-card__header__cont">
                            <h4 class="name">{{$data['refunded']}}</h4>
                            <div class="balance">@langg('Order Refunded')</div>
                        </div>
                    </div>
                    
                </div>
            </div>
          </div>
      </div>
      <div class="dashboard--content-item">
          <div class="row gy-4">
              @if ($referral->status == 1)
              <div class="col-md-12">
                <div class="dashboard--content-item">
                    <h6 class="dashboard-title">@langg('Referral URL')
                        @if ($referral->type == 'deposit')
                        <small class="text--success">
                            (@lang('While referred user deposit, you will get '.$referral->bonus_amount."% bonus of deposit amount for ".$referral->bonus_count." times"))
                        </small>
                        @else
                        <small class="text--success">
                            @if ($referral->get_bonus == 'both')
                             (@lang('While referred user register, you and new user both will get '.$referral->bonus_amount.' '.$gs->curr_code." bonus."))
                            @else
                             (@lang('While referred user register, you will get '.$referral->bonus_amount.' '.$gs->curr_code." bonus."))
                            @endif
                        </small>
                        @endif
                    </h6>
                    <div class="dashboard-refer">
                        <div class="input-group input--group">
                            <input type="text" id="link" class="form-control form--control bg--section"
                                value="{{route('user.register',['referral' => auth()->user()->username])}}" readonly>
                            <button class="input-group-text px-3 btn--primary copy-link" type="button">
                                <i class="far fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
              @endif
          </div>
      </div>
      <div class="dashboard--content-item">
          <h5 class="dashboard-title">@langg('Recent Orders')</h5>
          <div class="table-responsive">
            <table class="table bg--body">
                <thead>
                    <tr>
                      <th>@langg('ORDER ID')</th>
                      <th>@langg('DATE')</th>
                      <th>@langg('SERVICE')</th>
                      <th>@langg('LINK')</th>
                      <th>@langg('PRICE')</th>
                      <th>@langg('QTY')</th>
                      <th>@langg('START COUNT')</th>
                      <th>@langg('REMAIN')</th>
                      <th>@langg('STAUS')</th>
                     </tr>
                </thead>
                <tbody class="tbody">
                   
                    @forelse ($data['recentOrders'] as $item)
                        <tr>
                           
                            <td data-label="@langg('ID')">
                                <div>
                                    {{ $item->id }}
                                </div>
                            </td>
                            <td data-label="@langg('DATE')">
                                <div>
                                   {{ dateFormat($item->created_at,'d M Y') }}
                                </div>
                            </td>
                            <td data-label="@langg('SERVICE')" data-bs-toggle="tooltip" title="{{$item->service->title}}">
                                <div>
                                    {{ Str::limit($item->service->title,20) }}
                                </div>
                            </td>
                            <td data-label="@langg('LINK')" data-bs-toggle="tooltip" title="{{$item->link}}">
                                <div >
                                    {{ Str::limit($item->link) }}
                                </div>
                            </td>
                            <td data-label="@langg('PRICE')">
                                <div class="text--success">
                                    {{ number_format($item->price,4) }} {{$gs->curr_code}}
                                </div>
                            </td>
                            <td data-label="@langg('QTY')">
                                <div>
                                    {{ $item->qty }}
                                </div>
                            </td>
                           
                            <td data-label="@langg('START COUNT')">
                                <div>
                                    {{ $item->start_count ?? 'N/A' }}
                                </div>
                            </td>
                            <td data-label="@langg('REMAIN')">
                                <div>
                                    {{ $item->remains ?? 'N/A' }}
                                </div>
                            </td>
                            <td data-label="@langg('STAUS')">
                                <div>
                                    @if($item->status == 'pending')
                                        <span class="badge bg-warning">@langg('Pending')</span>
                                    @elseif($item->status == 'progress')
                                        <span class="badge bg-info">@langg('In Progress')</span>
                                    @elseif($item->status == 'completed')
                                        <span class="badge bg-success">@langg('Completed')</span>
                                    @elseif($item->status == 'partial')
                                        <span class="badge bg-dark">@langg('Partial')</span>
                                    @elseif($item->status == 'processing')
                                        <span class="badge bg-primary">@langg('Processing')</span>
                                    @elseif($item->status == 'canceled')
                                        <span class="badge bg-danger">@langg('Cancelled')</span>
                                    @elseif($item->status == 'refunded')
                                        <span class="badge bg-info">@langg('Refunded')</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12">
                                <div class="text-center">
                                    @langg('No result found')
                                </div>
                            </td>
                        </tr>
                    @endforelse
                   
                </tbody>
            </table>
          </div>
      </div>
  </div>
</section>

@endsection
@push('script')
    <script>
        'use strict';
        $('.copy-link').on('click',function() {
            var copyText = document.getElementById("link");
            copyText.select();
            copyText.setSelectionRange(0, 99999); 
            navigator.clipboard.writeText(copyText.value);
            toast('success','@lang('Link copied to clipboard')');
        });
    </script>
@endpush
