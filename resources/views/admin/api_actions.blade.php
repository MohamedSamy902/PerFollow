@extends('layouts.admin')

@section('title')
   @lang('Manage API Actions')
@endsection

@section('breadcrumb')
 <section class="section">
    <div class="section-header">
        <h1>@lang('Manage API Actions')</h1>
    </div>
</section>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card border-left border-primary">
            <div class="card-body">
                <span class="font-weight-bold">@lang('Note : ') </span> <code  class="text-warning">@lang('Turning off action means any API request with that action will not perform.')</code>
            </div>
        </div>
    </div>
    @foreach ($actions as $action)
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 currency--card">
        <div class="card">
            <div class="card-body">
                <label class="cswitch d-flex justify-content-between align-items-center">
                    <input class="cswitch--input update" value="{{$action}}" type="checkbox" {{$gs->api_actions[$action] == 1 ? 'checked':''}} /><span class="cswitch--trigger wrapper"></span>
                    <span class="cswitch--label font-weight-bold">@lang(ucfirst($action))</span>
                </label>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@push('script')
     <script>
            'use strict';
            (function ($) {
               $('.update').on('change', function () {
                var url = "{{route('admin.update.api.actions')}}"
                var val = $(this).val()
                var token = "{{csrf_token()}}"
                var data = {
                    action:val,
                    _token:token
                }
                $.post(url,data,function(response) {
                    if(response.error){
                        toast('error',response.error)
                        return false;
                    }
                    toast('success',response.success)
                })
               });
               
             
            })(jQuery);
     </script>
@endpush