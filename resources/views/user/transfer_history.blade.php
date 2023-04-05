@extends('layouts.user')

@section('title')
   @lang('Balance Transfer History')
@endsection

@section('breadcrumb')
   @lang('Balance Transfer History')
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
                            <th>@lang('Transaction')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Details')</th>
                            <th>@lang('Date')</th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse ($transfers as $item)
                            <tr>
                              <td data-label="@lang('Transaction')">{{$item->trnx}}</td>
                              <td data-label="@lang('Amount')">{{numFormat($item->amount)}} {{$gs->curr_code}}</td>
                              <td data-label="@lang('Details')">{{$item->details}}</td>
                              <td data-label="@lang('Date')">{{dateFormat($item->created_at)}}</td>
                            </tr>
                            @empty
                            <tr>
                                <td class="text-center" colspan="12">@lang('No data found!')</td>
                            </tr>
                          @endforelse
                        </tbody>
                      </table>
                    </div>
                    @if ($transfers->hasPages())
                        <div class="card-footer">
                            {{$transfers->links()}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection