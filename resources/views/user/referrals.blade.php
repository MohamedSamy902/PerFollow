@extends('layouts.user')

@section('title')
   @lang('Referrals')
@endsection

@section('content')
<section class="user-panel pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="table-responsive">
                      <table class="table table-vcenter card-table table-striped">
                        <thead>
                          <tr>
                            <th>@lang('Referred User')</th>
                            <th>@lang('Bonus Amount')</th>
                            <th>@lang('Got Bonus For')</th>
                            <th>@lang('Date')</th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse ($referrals as $item)
             
                            <tr>
                              <td data-label="@lang('Referred User')">{{$item->bonusfrom->username}}</td>
                              <td data-label="@lang('Bonus Amount')">{{numFormat($item->amount)}} {{$gs->curr_code}}</td>
                              <td data-label="@lang('Got Bonus For')">{{ucwords(str_replace('_',' ',$item->remark))}}</td>
                              <td data-label="@lang('Date')">{{dateFormat($item->created_at,'d M Y')}}</td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-center" colspan="12">@lang('No data found!')</td>
                            </tr>
                          @endforelse
                        </tbody>
                      </table>
                    </div>
                    @if ($referrals->hasPages())
                        <div class="card-footer">
                            {{$referrals->links()}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection