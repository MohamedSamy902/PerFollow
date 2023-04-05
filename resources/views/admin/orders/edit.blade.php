@extends('layouts.admin')

@section('title')
    @langg('Edit Order')
@endsection

@section('breadcrumb')
 <section class="section">
    <div class="section-header d-flex flex-wrap justify-content-between">
      <h1 class="mb-1 mr-auto">
         @langg('Edit Orders')
      </h1>
    </div>
</section>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{route('admin.order.all')}}" class="btn btn-dark"><i class="fas fa-backward"></i> @lang('Back')</a>
    </div>
    <div class="card-body">
       <form action="{{route('admin.order.update',$order->id)}}" method="POST">
        @csrf
            <div class="row">
                
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label>@langg('Start Counter')</label>
                        <input type="number" name="start_counter" value="{{$order->start_counter}}" class="form-control">
                    </div>
                </div> 
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label>@langg('Remains')</label>
                        <input type="number" name="remains" value="{{$order->remains}}" class="form-control">
                    </div>
                </div> 
                <div class="col-md-6 col-sm-12 col-xs-6">
                    <div class="form-group">
                        <label>@langg('Status')</label>
                        <select name="status" class="form-control">
                            <option value="awaiting" {{$order->status == 'awaiting' ? 'selected':''}}>@lang('Awaiting')</option>
                            <option value="pending" {{$order->status == 'pending' ? 'selected':''}}>@lang('Pending')</option>
                            <option value="processing" {{$order->status == 'processing' ? 'selected':''}}>@lang('Processing')</option>
                            <option value="progress" {{$order->status == 'progress' ? 'selected':''}}>@lang('In progress')</option>
                            <option value="completed" {{$order->status == 'completed' ? 'selected':''}}>@lang('Completed')</option>
                            <option value="partial" {{$order->status == 'partial' ? 'selected':''}}>@lang('Partial')</option>
                            <option value="canceled" {{$order->status == 'canceled' ? 'selected':''}}>@lang('Canceled')</option>
                            <option value="refunded" {{$order->status == 'refunded' ? 'selected':''}}>@lang('Refunded')</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-6">
                    <div class="form-group">
                        <label>@langg('Link')</label>
                        <input type="text" name="link" value="{{$order->link}}" class="form-control">
                    </div>
                </div>         
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label>@langg('Quantity')</label>
                        <input type="text"  value="{{$order->qty}}" readonly="readonly" class="form-control">
                    </div>
                </div> 
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label>@langg('Price')</label>
                        <input type="text"  value="{{round($order->price,3)}} {{$gs->curr_code}}" readonly="readonly" class="form-control">
                    </div>
                </div>

                <div class="col-md-12 text-right">
                    <button class="btn btn-primary btn-lg">@langg('Submit')</button>
                </div>
                  
            </div>
       </form>
    </div>
</div>
@endsection