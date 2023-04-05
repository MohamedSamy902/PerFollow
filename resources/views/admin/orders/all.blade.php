@extends('layouts.admin')

@section('title')
    @langg('Manage Orders')
@endsection

@section('breadcrumb')
 <section class="section">
    <div class="section-header d-flex flex-wrap justify-content-between">
      <h1 class="mb-1 mr-auto">
         @langg('Manage Orders')
      </h1>
      
    </div>
</section>
@endsection

@section('content')
<div class="row">

    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-body pb-0">
                <form action="" method="get" class="searchForm">
                    <div class="row">
                        <div class="col-md-3 col-xl-4">
                            <div class="form-group">
                                <select class="form-control" onChange="window.location.href=this.value">
                                    <option value="{{filter('status','all')}}" {{request('status') == 'all'?'selected':''}}>@lang('All Status')</option>
                                    <option value="{{filter('status','awaiting')}}"  {{request('status') == 'awaiting'?'selected':''}}>@lang('Awaiting')</option>
                                    <option value="{{filter('status','pending')}}"  {{request('status') == 'pending'?'selected':''}}>@lang('Pending')</option>
                                    <option value="{{filter('status','processing')}}"  {{request('status') == 'processing'?'selected':''}}>@lang('Processing')</option>
                                    <option value="{{filter('status','progress')}}"  {{request('status') == 'progress'?'selected':''}}>@lang('In progress')</option>
                                    <option value="{{filter('status','completed')}}"  {{request('status') == 'completed'?'selected':''}}>@lang('Completed')</option>
                                    <option value="{{filter('status','partial')}}"  {{request('status') == 'partial'?'selected':''}}>@lang('Partial')</option>
                                    <option value="{{filter('status','canceled')}}"  {{request('status') == 'canceled'?'selected':''}}>@lang('Canceled')</option>
                                    <option value="{{filter('status','refunded')}}"  {{request('status') == 'refunded'?'selected':''}}>@lang('Refunded')</option>
                                </select>
                            </div>
                        </div>
                            <div class="col-md-6 col-xl-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="search" value="{{request('search')}}" class="form-control " placeholder="@lang('Search with...')">
                                        <span class="input-group-text p-0 border-0">
                                            <select name="field" class="form-control border-left-0">
                                                <option value="id" @if(request('field') == 'order_id') selected @endif>@lang('Order ID')</option>
                                                <option value="api_order_id" @if(request('field') == 'api_order_id') selected @endif>@lang('API Order ID')</option>
                                                <option value="service_id" @if(request('field') == 'service_id') selected @endif>@lang('Servie ID')</option>
                                                <option value="link" @if(request('field') == 'link') selected @endif>@lang('Link')</option>
                                            </select>
                                        </span>
    
                                    </div>
                                </div>
                            </div>
    
    
                            <div class="col-md-3 col-xl-2">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i> @lang('Search')</button>
                                </div>
                            </div>
                        

                        <div class="col-md-3 col-xl-2">
                            <div class="form-group">
                                <a href="{{route('admin.order.all')}}" class="btn btn-dark btn-block"><i class="fas fa-broom"></i> @lang('Reset')</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <form action="{{route('admin.order.multi.action')}}" method="POST">
            @csrf
            <div class="card">
                <div class="card-header">
                    <div class="form-group mb-0">
                        <select name="action" class="form-control mb-1 action">
                            <option value="">@lang('Select Action')</option>
                            <option value="1">@lang('Delete Orders')</option>
                            <option value="2">@lang('Change Status')</option>
                           
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <select name="status" class="form-control ml-2 mb-1 status" disabled>
                            <option value="">@lang('Select Status')</option>
                            <option value="awaiting">@lang('Awaiting')</option>
                            <option value="pending">@lang('Pending')</option>
                            <option value="processing">@lang('Processing')</option>
                            <option value="progress">@lang('In progress')</option>
                            <option value="completed">@lang('Completed')</option>
                            <option value="partial">@lang('Partial')</option>
                            <option value="canceled">@lang('Canceled')</option>
                            <option value="refunded">@lang('Refunded')</option>
                           
                        </select>
                    </div>
                   
                    <button class="btn btn-primary ml-4 mb-1" type="submit">@langg('Update')</button>
                  
                </div>
               
                <div class="card-body text-center">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th> 
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input shadow-none check-all" id="customCheck">
                                        <label class="custom-control-label" for="customCheck"></label>
                                    </div>
                                
                                </th>
                                <th>@langg('User')</th>
                                <th>@langg('Order ID')</th>
                                <th>@langg('Service/Price')</th>
                                <th>@langg('Link/QTY')</th>
                                <th>@langg('Counter / API Response')</th>
                                <th>@langg('Status')</th>
                                <th>@langg('Ordered at')</th>
                                <th>@langg('Action')</th>
                            </tr>
                            @forelse ($orders as $k => $order)
                                <tr>
                                    <td data-label="@lang('#')">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input shadow-none check-order" id="customCheck{{$k}}" name="orders[{{$k}}]" value="{{$order->id}}">
                                            <label class="custom-control-label" for="customCheck{{$k}}"></label>
                                        </div>
                                    </td>
                                    <td data-label="@langg('User')"><a href="{{route('admin.user.details',$order->user_id)}}">{{ $order->user->username }}</a></td>
                                  
                                    <td data-label="@langg('Order ID')">
                                        {{ $order->id }}
                                    </td>
                                    <td data-label="@langg('Service Name / Price')" data-toggle="tooltip" title="{{$order->service->title}}">
                                        <span>{{ Str::limit($order->service->title,30) }}</span> <br> <hr>
                                        <span class="text-primary mt-2">@langg('Price : ') {{round($order->price,3)}} {{$gs->curr_code}}</span>
                                    </td>
                                    <td data-label="@langg('Link/QTY')">
                                        <span class="text-primary">{{ $order->link }}</span><br> <hr>
                                        <span class="text-info">{{'Quantity : '. $order->qty }}</span>
                                    </td>
                                    <td data-label="@langg('Counter / API response')" class="p-3">
                                        <span class="text-success">{{'Start Counter : '. $order->start_counter }}</span> <br> 
                                        <span class="text-danger">{{'Remains : '. $order->remains }}</span> <br> <hr>
                                        <small class="text-primary mb-2"><b>{{ $order->api_response ?? 'N/A' }}</b></small>
                                    </td>
                                
                                    <td data-label="@lang('Status')" >
                                        @if($order->status=='awaiting') <span
                                            class="badge badge-pill badge-warning">{{'Awaiting'}}</span>
                                        @elseif($order->status == 'pending') <span
                                            class="badge badge-pill badge-warning">{{'Pending'}}</span>
                                        @elseif($order->status == 'processing') <span
                                            class="badge badge-pill badge-info">{{'Processing'}}</span>
                                        @elseif($order->status == 'progress') <span
                                            class="badge badge-pill badge-dark">{{'In progress'}}</span>
                                        @elseif($order->status == 'completed') <span
                                            class="badge badge-pill badge-success">{{'Completed'}}</span>
                                        @elseif($order->status == 'partial') <span
                                            class="badge badge-pill badge-secondary">{{'Partial'}}</span>
                                        @elseif($order->status == 'canceled') <span
                                            class="badge badge-pill badge-danger">{{'Canceled'}}</span>
                                        @elseif($order->status == 'refunded') <span
                                            class="badge badge-pill badge-danger">{{'Refunded'}}</span>
                                        @endif
                                    
                                        
                                    </td>
    
                                  
                                    <td data-label="@langg('Ordered at')">
                                        {{ dateFormat($order->created_at,'d M Y') }}
                                    </td>
    
                                    <td data-label="@langg('Action')">
                                        <div class="d-flex flex-wrap align-items-center justify-content-end justify-content-lg-center">
                                            <a href="{{route('admin.order.edit',$order->id)}}" class="btn btn-primary btn-sm m-1"><i class="fas fa-edit"></i></a>
                    
                                            <button class="btn btn-danger reject m-1 btn-sm remove m-1" data-url="{{route('admin.order.remove',$order->id)}}"  data-toggle="tooltip" title="@lang('Remove the order')"><i class="fas fa-trash-alt"></i></button>
    
                                        </div>
                                    </td>
                                </tr>
                             @empty
    
                                <tr>
                                    <td class="text-center" colspan="100%">@langg('No Data Found')</td>
                                </tr>
    
                            @endforelse
                        </table>
                    </div>
                </div>
                @if ($orders->hasPages())
                    <div class="card-footer">
                        {{ $orders->links('admin.partials.paginate') }}
                    </div>
                @endif
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5 class="msg mt-3">@langg('Want to delete this order?')</h5>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn-danger">@lang('Confirm')</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('style')
    <style>
        select.form-control:not([size]):not([multiple]) {
           height: calc(2.25rem + 2px)!important;
        }
    </style>
@endpush

@php
  $url = http_build_query(request()->except('search','field'));
  $url = str_replace("amp%3B","",$url);
  $queryStrings = json_encode(request()->query());
@endphp

@push('script')
<script>
  'use strict';
  $('.searchForm').on('submit',function(e){
    e.preventDefault();
    var data = $(this).serialize();
    var url = '{{url()->current()}}?{{$url}}';
    url = url.replaceAll('amp;','');
    var queryString = "{{$queryStrings}}"

    var delim;
    if(queryString.length > 2) delim = "&" 
    else  delim = ""

    window.location.href = url+delim+data;
  });

  $('.remove').on('click',function(e){
    e.preventDefault();
    var url = $(this).data('url');
    $('#statusModal form').attr('action',url);
    $('#statusModal').modal('show');
  });

  $('.check-all').on('change',function () { 
      if($(this).is(':checked')){
            $.each($(".check-order"), function (i, element) { 
                $(element).attr('checked',true);
            });
        }
        else{
            $.each($(".check-order"), function (i, element) { 
                $(element).attr('checked',false);
            });
        }
    })

    $('.action').on('change',function () { 
        var action = $(this).val();
        if(action == 2) $('.status').removeAttr('disabled');
        else $('.status').attr('disabled',true);
       
    })

  </script>

@endpush

@push('style')
    <style>
        .card .card-header .btn{
            padding: 5px 15px !important
        }
    </style>
@endpush