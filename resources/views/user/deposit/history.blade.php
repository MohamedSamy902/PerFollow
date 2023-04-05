@extends('layouts.user')

@section('title')
   @langg('Deposit History')
@endsection


@section('content')
<section class="user-panel pt-50 pb-100">
  <div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                  <table class="table table-vcenter card-table table-striped">
                    <thead>
                      <tr>
                        <th>@langg('Amount')</th>
                        <th>@langg('Amount In '.$gs->curr_code)</th>
                        <th>@langg('Charge')</th>
                        <th>@langg('Method')</th>
                        <th>@langg('Status')</th>
                        <th>@langg('Reject Reason')</th>
                        <th>@langg('Date')</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($deposits as $item)
           
                        <tr>
                          <td data-label="@langg('Amount')">{{amount($item->amount,2)}} {{$item->currency->code}}</td>
                          <td class="text--success" data-label="@langg('Amount In '.$gs->curr_code)">{{amountConv($item->amount,$item->currency)}} {{$gs->curr_code}}</td>
                          <td data-label="@langg('Charge')">{{amount($item->charge,2)}} {{$item->currency->code}}</td>
                          <td data-label="@langg('Method')">{{$item->gateway->name}}</td>
                          <td data-label="@langg('Status')"><span class="badge {{$item->status == 'completed' ? 'bg--success':'bg--warning'}}">{{$item->status}}</span></td>
                          <td data-label="@langg('Method')" class="hov" title="{{$item->reject_reason}}">
                            @if ($item->status == 'rejected' && $item->reject_reason != null)
                              <small class="text--danger">{{Str::limit($item->reject_reason,25)}}</small>
                            @else
                             N/A
                            @endif
                          </td>
                          <td data-label="@langg('Date')">{{dateFormat($item->created_at)}}</td>
                        </tr>
                        @empty
                        <tr>
                            <td class="text-center" colspan="12">@langg('No data found!')</td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
  </div>
</section>
@endsection

@push('style')
    <style>
      .hov{
        cursor: pointer;
      }
    </style>
@endpush