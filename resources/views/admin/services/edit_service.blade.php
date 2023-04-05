@extends('layouts.admin')

@section('title')
    @lang('Edit Service')
@endsection

@section('breadcrumb')
 <section class="section">
    <div class="section-header d-flex flex-wrap justify-content-between">
      <h1 class="mb-1 mr-auto">@langg('Edit Service')</h1>
    </div>
</section>
@endsection

@section('content')

   <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-end">
                @if (session('all'))
                <a href="{{session('all')}}" class="btn btn-dark btn-sm"><i class="fas fa-backward"></i> @langg('Back')</a>
                @else
                <a href="{{route('admin.services',$service->category->slug)}}" class="btn btn-dark btn-sm"><i class="fas fa-backward"></i> @langg('Back')</a>
                @endif
            </div>
            <div class="card-body ">
                <form action="{{route('admin.service.update')}}" method="POST" class="form">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('Service Type')</label>
                                <select class="form-control type" name="type" required>
                                    <option value="2" {{$service->type == 2 ? 'selected':''}}>@lang('Manual')</option>
                                    <option value="1" {{$service->type == 1 ? 'selected':''}}>@lang('API Provider')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        @if ($service->type == 1)
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('API Provider')</label>
                                    <select class="form-control provider" name="provider_id">
                                        <option value="">@lang('Select Provider')</option>
                                        @foreach($providers as $provider)
                                            <option value="{{ $provider->id  }}" {{$service->provider_id == $provider->id ? 'selected':''}}>{{ $provider->name  }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('API Service')</label>
                                    <select name="service_id" class="form-control service" disabled></select>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="api-field">
                        @if ($service->type == 1)
                        @endif
                    </div>
                    <hr>
                    <input type="hidden" name="id" value="{{$service->id}}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('Select Category')</label>
                                <select class="form-control" id="category_id" name="category_id" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id  }}" {{$service->category_id == $category->id ? 'selected':''}}>@lang($category->name)</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label>@lang('Title')</label>
                                <input type="text" name="title" value="{{ old('title',$service->title) }}" placeholder="@lang('Title')" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('Minimum Amount')</label>
                                <input type="number" class="form-control" name="min_amount" value="{{ old('min_amount',round($service->min_amount)) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('Maximum Amount')</label>
                                <input type="number" class="form-control" name="max_amount" value="{{ old('max_amount',round($service->max_amount)) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('Rate/1k')</label>
                                <input type="text" class="form-control" name="price"  value="{{ old('price',round($service->price,2)) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('Status')</label>
                                <select class="form-control" name="status" required>
                                    <option value="1" {{$service->status == 1 ? 'selected':''}}>@lang('Active')</option>
                                    <option value="0" {{$service->status == 0 ? 'selected':''}}>@lang('Inactive')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                   
                    
                    <div class="form-group">
                        <label class="control-label " for="fieldone">@lang('Description')</label>
                        <textarea class="form-control" rows="4" placeholder="Description " name="description">{{$service->description}}</textarea>
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn  btn-primary mt-4 btn-lg">
                            @lang('Update')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
   </div>
   <div id="loader" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered text-center" role="document">
        <div class="lds-facebook text-center"><div></div><div></div><div></div></div>
    </div>
  </div>
@endsection
@push('script')
    <script>
        $(document).ready(function () {
            "use strict";
            $('.type').on('change',function () { 
                var type = $(this).val();
                if(type == 1){
                    $('.field').html(`<div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('API Provider')</label>
                                    <select class="form-control provider" name="provider_id">
                                        <option value="">@lang('Select Provider')</option>
                                        @foreach($providers as $provider)
                                            <option value="{{ $provider->id  }}">{{ $provider->name  }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('API Service')</label>
                                    <select name="service_id" class="form-control service" disabled></select>
                                </div>
                            </div>
                        </div>`);
                }else{
                    $('.field').html('');
                    $('.api-field').html('')
                }
             })
            $('#category_id').select2({
                selectOnClose: true
            });

            $(document).on('change','.provider',function () { 
                var provider_id = $(this).val();
                $('#loader').modal('show');
                $.ajax({
                    url: "{{ route('admin.get.service') }}",
                    type: "GET",
                    data: {
                        provider_id: provider_id,
                    },
                    success: function (data) {

                        $(document).find('.service').attr('disabled',false);
                        $(document).find('.service').select2({
                            selectOnClose: true
                        });
                        $(document).find('.service').html(data);
                        $('#loader').modal('hide');
                    }
                });
            })

            $(document).on('change','.service',function () { 
                var data = $('.service option:selected').data('service')
                $('.api-field').html(`<div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('Api Rate')</label>
                                    <input type="text" class="form-control" readonly value="${data.rate}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('Api Min')</label>
                                    <input type="text" class="form-control" readonly value="${data.min}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>@lang('Api Max')</label>
                                    <input type="text" class="form-control" readonly value="${data.max}">
                                </div>
                            </div>
                            
                        </div>`);
            })


            var provider_id = "{{ $service->provider_id }}";
            $('#loader').modal('show');
            $.ajax({
                url: "{{ route('admin.get.service') }}",
                type: "GET",
                data: {
                    provider_id: provider_id,
                },
                success: function (data) {

                    $(document).find('.service').attr('disabled',false);
                    $(document).find('.service').select2({
                        selectOnClose: true
                    });
                    $(document).find('.service').html(data);
                    $('#loader').modal('hide');
                }
            });
        
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