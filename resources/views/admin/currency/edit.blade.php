@extends('layouts.admin')

@section('title')
   @langg('Edit Currency')
@endsection

@section('breadcrumb')
 <section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>@langg('Edit Currency')</h1>
        <a href="{{route('admin.currency.index')}}" class="btn btn-primary btn-sm"><i class="fas fa-backward"></i> @langg('Back')</a>
    </div>
</section>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
           <div class="card">
                <div class="card-body">
                    <form action="{{route('admin.currency.update',$currency->id)}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>@langg('Currency Name')</label>
                                <input class="form-control" type="text" name="curr_name" required value="{{$currency->curr_name}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>@langg('Currency Code')</label>
                                <input class="form-control" type="text" name="code" required value="{{$currency->code}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>@langg('Currency Symbol')</label>
                                <input class="form-control" type="text" name="symbol"  required value="{{$currency->symbol}}">
                            </div>
                  
                            <div class="form-group col-md-6">
                                <label>@langg('Currency Rate')</label>
                                <div class="input-group has_append">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text cur_code">1 {{$gs->curr_code}}</div>
                                    </div>
                                    <input type="text" class="form-control" placeholder="0" name="rate" value="{{ numFormat($currency->rate,8) }}"/>
                                    <div class="input-group-append">
                                        <div class="input-group-text">{{$currency->code}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group {{$currency->default == 1 ? 'col-md-12' : 'col-md-6' }}">
                                <label>@langg('Currency Type')</label>
                                <select class="form-control" name="type" required>
                                    <option value="">--@langg('Select Type')--</option>
                                    <option value="1" {{$currency->type == 1 ? 'selected':''}}>@langg('FIAT')</option>
                                    <option value="2" {{$currency->type == 2 ? 'selected':''}}>@langg('CRYPTO')</option>
                                </select>
                            </div>
                            @if ($currency->default != 1)
                            <div class="form-group col-md-6">
                                <label>@langg('Set As Default') </label>
                                <select class="form-control" name="default" required>
                                    <option value="">--@langg('Select')--</option>
                                    <option value="1" {{$currency->default == 1 ? 'selected':''}}>@langg('Yes')</option>
                                    <option value="0" {{$currency->default == 0 ? 'selected':''}}>@langg('No')</option>
                                </select>
                            </div>
                            @endif
                            <div class="form-group col-md-12">
                                <label>@langg('Status') </label>
                                <select class="form-control" name="status" required>
                                    <option value="">--@langg('Select')--</option>
                                    <option value="1" {{$currency->status == 1 ? 'selected':''}}>@langg('Active')</option>
                                    <option value="0" {{$currency->status == 0 ? 'selected':''}}>@langg('Inactive')</option>
                                </select>
                            </div>
                        </div>
                       @if (access('update currency'))
                       <div class="form-group text-right col-md-12">
                           <button class="btn  btn-primary btn-lg" type="submit">@langg('Update')</button>
                       </div>
                       @endif
                    </form>
                </div>
           </div>
        </div>
    </div>
@endsection