@extends('layouts.user')

@section('title')
    @langg('Order History')
@endsection

@section('content')
<section class="user-panel pt-50 pb-100">
    <div class="container">
       
        <div class="card">
            <div class="card-header bg-white border-0 pb-0 pt-3">
                <div class="row justify-content-end">
                    <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                            <input type="text" name="order" id="order" class="form-control" placeholder="@lang("'Order ID' OR 'Service Name' OR 'Status'")">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="dashboard--content-item">
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
                                       
                                        @forelse ($orders as $item)
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
                                                        {{ $item->start_count ?? 0 }}
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
                </div>
            </div>
            @if ($orders->hasPages())
                <div class="card-footer bg-white border-0 pb-3">
                    {{ $orders->links() }}
                </div>
            @endif
           
        </div>
    </div>
    <div id="loader" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="lds-facebook text-center"><div></div><div></div><div></div></div>
        </div>
    </div>
</section>
@stop

@push('script')
    <script>
        'use strict';
        
        $('#order').on('input keyup',function(){
            var order = $(this).val();
            var data = {status:"{{request('status')}}",order:order};
            $('#loader').modal('show');
            setTimeout(() => {
                $.get("{{route('user.get.orders')}}", data,
                    function (res) {
                       $('.tbody').html(res) 
                       $('#loader').modal('hide');
                       $('#order').focus() 
                    },
                );
            }, 800);
        });
       
    </script>
@endpush

@push('style')
    <style>
        .lds-facebook {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
        }
        .lds-facebook div {
            display: inline-block;
            position: absolute;
            left: 250px;
            width: 16px;
            background: rgb(0, 0, 0);
            animation: lds-facebook 1.2s cubic-bezier(0, 0.5, 0.5, 1) infinite;
        }
        .lds-facebook div:nth-child(1) {
            left: 250px;
            animation-delay: -0.24s;
        }
        .lds-facebook div:nth-child(2) {
            left: 274px;
            animation-delay: -0.12s;
        }
        .lds-facebook div:nth-child(3) {
            left: 298px;
            animation-delay: 0;
        }
        @keyframes lds-facebook {
        0% {
            top: 8px;
            height: 64px;
        }
        50%, 100% {
            top: 24px;
            height: 32px;
        }
        }

    </style>
@endpush