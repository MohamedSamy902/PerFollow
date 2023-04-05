@extends('layouts.admin')
@section('title')
    @lang('List of Services')
@endsection
@section('breadcrumb')
 <section class="section">
    <div class="section-header d-flex flex-wrap justify-content-between">
      <h1 class="mb-1 mr-auto">
          @if (@$category)
          @langg('Services : ') {{$category->name}}
          @else
          @langg('All services')
          @endif
      </h1>
      
      <a href="{{route('admin.service.create')}}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> @langg('Add service')</a>
      
    </div>
</section>
@endsection
@section('content')
<div class="row">

    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
            <div class="card-body pb-0">
                <form action="" method="get" id="form">
                    <div class="row">
                        <div class="col-md-3 col-xl-2">
                            <div class="form-group">
                                <select name="provider" id="provider" class="form-control">
                                    <option value="" @if(request('provider') == '') selected @endif>@lang('All Provider')</option>
                                    @foreach(DB::table('providers')->get() as $provider)
                                        <option value="{{ $provider->id }}" @if(request('provider') == $provider->id) selected @endif>{{$provider->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if (!@$category)
                        <div class="col-md-3 col-xl-2">
                            <div class="form-group">
                                <select name="category" class="form-control select2">
                                    <option value="">@lang('All Category')</option>
                                    @foreach(DB::table('categories')->get() as $cat)
                                        <option value="{{$cat->id}}" @if(request('category') == $cat->id) selected @endif>{{$cat->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endif

                        <div class="col-md-3 col-xl-2">
                            <div class="form-group">
                                <select name="status" class="form-control">
                                    <option value="" @if(request('status') == '') selected @endif>@lang('All Status')</option>
                                    <option value="1" @if(request('status') == '1') selected @endif>@lang('Active')</option>
                                    <option value="0" @if(request('status') == '0') selected @endif>@lang('Inactive')</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-xl-2">
                            <div class="form-group">
                                <input type="text" name="service" value="{{request('service')}}" class="form-control" placeholder="@lang('Service Name')">
                            </div>
                        </div>


                        <div class="col-md-3 col-xl-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-search"></i> @lang('Search')</button>
                            </div>
                        </div>
                        <div class="col-md-3 col-xl-2">
                            @if (!@$category)
                            <div class="form-group">
                                <a href="{{route('admin.service.all')}}" class="btn btn-dark btn-block"><i class="fas fa-broom"></i> @lang('Reset')</a>
                            </div>
                            @else
                            <div class="form-group">
                                <a href="{{route('admin.services',$category->slug)}}" class="btn btn-dark btn-block"><i class="fas fa-broom"></i> @lang('Reset')</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <form action="{{route('admin.service.multi.action')}}" method="POST">
            @csrf
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="d-flex">
                        <div class="form-group mb-0">
                            <select name="status" class="form-control mb-1 action" required>
                                <option value="">@lang('Select Action')</option>
                                <option value="1">@lang('Activate')</option>
                                <option value="0">@lang('Deactivate')</option>
                            </select>
                        </div>
                        <button class="btn btn-primary ml-4 mb-1" type="submit">@langg('Update')</button>
                    </div>
                    @if (@$category)
                      <a href="{{route('admin.service.category')}}" class="btn btn-dark btn-sm"><i class="fas fa-backward"></i> @langg('Back')</a>
                    @endif
                </div>
                <div class="card-body text-center">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th> 
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input shadow-none check-all" id="customCheck">
                                        <label class="custom-control-label" for="customCheck"></label>
                                    </div>
                                
                                </th>
                                <th>@langg('ID')</th>
                                <th>@langg('Service Name')</th>
                                <th>@langg('Category')</th>
                                <th>@langg('Provider Name')</th>
                                <th>@langg('Rate/1K')</th>
                                <th>@langg('Limit')</th>
                                <th>@langg('Status')</th>
                                <th>@langg('Action')</th>
                            </tr>
                            @forelse ($services as $key => $service)
                                <tr>
                                    <td data-label="@lang('#')">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input shadow-none check-order" id="customCheck{{$key}}" name="services[{{$key}}]" value="{{$service->id}}">
                                            <label class="custom-control-label" for="customCheck{{$key}}"></label>
                                        </div>
                                    </td>
                                    <td data-label="@langg('ID')">{{ $service->id }}</td>
                                  
                                    <td data-label="@langg('Service Name')" data-toggle="tooltip" title="{{$service->title}}">
                                        {{ Str::limit($service->title,30) }}
                                    </td>
                                    <td data-label="@langg('Service Name')" data-toggle="tooltip" title="{{$service->category->name}}">
                                        {{ Str::limit($service->category->name,30) }}
                                    </td>
                                    <td data-label="@langg('Provider Name')">
                                        {{ $service->provider->name ?? 'N/A' }}
                                    </td>
                                    <td data-label="@langg('Rate/1K')">
                                        {{ round($service->price,3) }} {{ $gs->curr_code }}
                                    </td>
                                    <td data-label="@langg('Limit')">
                                        {{'min : '. round($service->min_amount).' - max: '. round($service->max_amount)}}
                                    </td>
    
                                    <td data-label="@langg('Status')">
                                        @if($service->status == 1)
                                            <span class="badge badge-success">@langg('Active')</span>
                                        @else
                                            <span class="badge badge-warning">@langg('Deactive')</span>
                                        @endif
                                    </td>
    
                                    <td data-label="@langg('Action')">
                                        <div class="d-flex flex-wrap align-items-center justify-content-end justify-content-lg-center">
                                            <a href="{{route('admin.service.edit',$service->id)}}" class="btn btn-primary btn-sm m-1"><i class="fas fa-edit"></i></a>
                                            @if($service->status == 1)
                                                <button class="btn btn-danger reject m-1 btn-sm c_status m-1" type="button" data-url="{{route('admin.service.status',$service->id)}}" data-status="{{$service->status}}" data-toggle="tooltip" title="@lang('Deactive the service')"><i class="fas fa-ban"></i></button>
                                            @else
                                                <button type="button" class="btn btn-success reject m-1 btn-sm c_status m-1" data-url="{{route('admin.service.status',$service->id)}}" data-status="{{$service->status}}" data-toggle="tooltip" title="@lang('Active the service')"><i class="fas fa-check"></i></button>
                                            @endif
                                          
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
                @if ($services->hasPages())
                    <div class="card-footer">
                        {{ $services->links('admin.partials.paginate') }}
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
                    <h5 class="msg mt-3"></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn-primary">@lang('Confirm')</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('script')
    <script>
        'use strict';
        $('.c_status').on('click', function(e){
            var route = $(this).data('url');
            var status = $(this).data('status');
            var status_text;
            if(status == 1) status_text = '@langg("Are you sure to deactive this service?")';
            else status_text = '@langg("Are you sure to active this service?")';
            $('#statusModal').find('.msg').text(status_text);
            $('#statusModal').find('form').attr('action', route);
            $('#statusModal').modal('show');
        });

        $('.select2').select2();

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

    </script>
@endpush


@push('style')
  <style>
      .card .card-header .btn{
          padding: 5px 15px !important
      }
  </style>
@endpush