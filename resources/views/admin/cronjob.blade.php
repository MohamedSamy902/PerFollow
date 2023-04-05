@extends('layouts.admin')

@section('title')
    @langg('Manage Cron Job')
@endsection

@section('breadcrumb')
 <section class="section">
    <div class="section-header">
    <h1>@langg('Manage Cron Job')</h1>
    </div>
</section>
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-sm-12">
            <div class="card border-left border-primary">
                <div class="card-body">
                    <span class="font-weight-bold">@langg('Note') :  </span> <span class="text-danger">@langg('If you want to place the order to api automatic and also for update the order, you must put the cron URL to your server. Once a day for cron job time is recommended.')</span>
                    <hr>
                    <div class="form-group my-3">
                        <label for="">@langg('Cron URL : ')</label>
                        <input id="" class="form-control" type="text" value="{{url('/cron-job')}}" readonly>
                    </div>

                    
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <span class="font-weight-bold">@langg('Note') :  </span> <span class="text-danger">@langg('If you want to update the order status or start counter or remains automatically from the api, keep turn on the switch else turn it off.')</span>
                    <hr>
                    <label class="cswitch d-flex justify-content-between align-items-center">
                        <input class="cswitch--input update"  type="checkbox" {{$gs->cron_auto_status == 1 ? 'checked':''}}><span class="cswitch--trigger wrapper"></span>
                        <span class="cswitch--label font-weight-bold">@langg('Update Order Status/Start counter automatically.')</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
     <script>
            'use strict';
            (function ($) {
               $('.update').on('change', function () {
                var url = "{{route('admin.cronjob.status')}}"
                var val = $(this).val()
                var token = "{{csrf_token()}}"
                var data = {
                    status:val,
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