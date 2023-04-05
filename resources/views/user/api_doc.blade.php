@extends('layouts.user')

@section('title')
@lang('API doc')
@endsection

@section('content')

<div class="user-panel pt-100 pb-100 api-documentation">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 mb-4">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="card-title mt-1">@langg('API Documentation')</h5>
                    </div>
                    <div class="card-body">
                        <div class="x_content">
                            <code>@langg('Note : Please read the API intructions carefully. Its your solo
                                responsability what you add by our API')
                            </code>
                            <table class="table table-hover table-bordered mt-3">
                                <thead>
                                    <tr>
                                        <th>@langg('Entities')</th>
                                        <th>@langg('Value')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>@langg('HTTP Method')</strong></td>
                                        <td>@langg('POST')</td>
                                    </tr>
                                    <tr>
                                        <td><strong>@langg('Response format')</strong></td>
                                        <td>@langg('Json')</td>
                                    </tr>
                                    <tr>
                                        <td><strong>@langg('API URL')</strong></td>
                                        <td>
                                            <a href="javascript:void(0)">{{url('api/v1')}}</a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><strong>@langg('API Key')</strong></td>
                                        <td>
                                            <p class="old-key">{{auth()->user()->api_key}}</p>
                                            <a  href="javascript:void(0)" class="btn btn-primary btn-sm gk">@langg('Generate New Key')</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>@langg('Example Code')</strong></td>
                                        <td>
                                            <a download="" href="{{asset('assets/files/api_example_code.txt')}}" class="btn btn-primary" target="_blank">@langg('Download PHP Code Examples')</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            
                        </div>
                       
                    </div>
                </div>
            </div>

            <div class="col-md-10">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="card-title mt-1">@langg('Place new Order')</h5>
                    </div>
                    <div class="card-body">
                        <div class="x_content">
                          
                            <!-- Default -->
                            <table class="table table-hover table-bordered service-default">
                                <thead>
                                    <tr>
                                        <th>@langg('Parameter')</th>
                                        <th>@langg('Description')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><b>@langg('key')</b></td>
                                        <td>@langg('Your API key')</td>
                                    </tr>
                                    <tr>
                                        <td><b>@langg('action')</b></td>
                                        <td>@langg('add')</td>
                                    </tr>
                                    <tr>
                                        <td><b>@langg('service')</b></td>
                                        <td>@langg('Service ID')</td>
                                    </tr>
                                    <tr>
                                        <td><b>@langg('link')</b></td>
                                        <td>@langg('Link to page')</td>
                                    </tr>
                                    <tr>
                                        <td><b>@langg('quantity')</b></td>
                                        <td>@langg('Needed quantity')</td>
                                    </tr>
                                   
                                </tbody>
                            </table>

                            <div class="title my-3">
                                <h4>@langg('Example response :')</h4>
                            </div>
                           
                                <pre>{
"status": "success",
"order": 32
}
        </pre>
                            
                        </div>
                    </div>
                </div>
            </div>

        
            <div class="col-md-10 mt-3">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="card-title mt-1">@langg('Status Order')</h5>
                    </div>
                    <div class="card-body">

                        <div class="x_content">
                            <table class="table table-hover table-bordered projects">
                                <thead>
                                    <tr>
                                        <th>@langg('Parameter')</th>
                                        <th>@langg('Description')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><b>@lang('key')</b></td>
                                        <td>@langg('Your API key')</td>
                                    </tr>
                                    <tr>
                                        <td><b>@langg('action')</b></td>
                                        <td>@langg('status')</td>
                                    </tr>
                                    <tr>
                                        <td><b>@langg('order')</b></td>
                                        <td>@langg('Order ID')</td>
                                    </tr>
                                </tbody>
                            </table>


                            <div class="title my-3">
                                <h4>@langg('Example response :')</h4>
                            </div>
                            
                                <pre>{
"order": "32",
"status": "pending",
"charge": "0.0360",
"start_count": "0",
"remains": "0"
}
        </pre>
                            
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-10 mt-3">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="card-title mt-1">@langg('Multiple orders status')</h5>
                    </div>
                    <div class="card-body">
                        <div class="x_content">
                            <table class="table table-hover table-bordered projects">
                                <thead>
                                    <tr>
                                        <th>@langg('Parameter')</th>
                                        <th>@langg('Description')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><b>@langg('key')</b></td>
                                        <td>@langg('Your API key')</td>
                                    </tr>
                                    <tr>
                                        <td><b>@langg('action')</b></td>
                                        <td>@langg('status')</td>
                                    </tr>
                                    <tr>
                                        <td><b>@langg('orders')</b></td>
                                        <td>@langg('Order IDs') (array data)</td>
                                    </tr>
                                </tbody>
                            </table>


                            <div class="title my-3">
                                <h4>@langg('Example response :')</h4>
                            </div>
                            
                                <pre>  {
  "12": {
      "order": "12",
      "status": "processing",
      "charge": "1.2600",
      "start_count": "0",
      "remains": "0"
  },
  "2": "Incorrect order ID",
  "13": {
      "order": "13",
      "status": "pending",
      "charge": "0.6300",
      "start_count": "0",
      "remains": "0"
  }
}
        </pre>
                         
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-10 my-3">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="card-title mt-1">@langg('Services Lists')</h5>
                    </div>
                    <div class="card-body">
                        <div class="x_content">
                            <table class="table table-hover table-bordered projects">
                                <thead>
                                    <tr>
                                        <th>@langg('Parameter')</th>
                                        <th>@langg('Description')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><b>@langg('key')</b></td>
                                        <td>@langg('Your API key')</td>
                                    </tr>
                                    <tr>
                                        <td><b>@langg('action')</b></td>
                                        <td>@langg('services')</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="title my-3">
                                <h4>@langg('Example response : ')</h4>
                            </div>
                           
                                <pre>[
{
  "service": "5",
  "name": "Instagram Followers [15K] ",
  "category": "Instagram - Followers [Guaranteed\/Refill] - Less Drops \u2b50",
  "rate": "1.02",
  "min": "500",
  "max": "10000"

},
{
  "service": "9",
  "name": "Instagram Followers - Max 300k - No refill - 30-40k\/Day",
  "category": "Instagram - Followers [Guaranteed\/Refill] - Less Drops \u2b50",
  "rate": "0.04",
  "min": "500",
  "max": "300000"

},
{
  "service": "10",
  "name": "Instagram Followers ( 30 days auto refill ) ( Max 350K ) (Indian Majority )",
  "category": "Instagram - Followers [Guaranteed\/Refill] - Less Drops \u2b50",
  "rate": "1.2",
  "min": "100",
  "max": "350000"

}
]
        </pre>
                            
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-10 mt-3">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="card-title mt-1">@langg('Balance')</h5>
                    </div>
                    <div class="card-body">

                        <div class="x_content">
                            <table class="table table-hover table-bordered projects">
                                <thead>
                                    <tr>
                                        <th>@langg('Parameter')</th>
                                        <th>@langg('Description')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><b>@langg('key')</b></td>
                                        <td>@langg('Your API key')</td>
                                    </tr>
                                    <tr>
                                        <td><b>@langg('action')</b></td>
                                        <td>@langg('balance')</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="title my-3">
                                <h4>Example response:</h4>
                            </div>
                            
                                <pre>  {
  "status": "success",
  "balance": "0.03",
  "currency": "USD"
}
        </pre>
                         
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>


<div class="modal fade" id="api_key" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@langg('API KEY')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" class="form-control key"  readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@langg('Close')</button>
            </div>
        </div>
    </div>
</div>
@stop

@push('style')
<style>
    .api-documentation pre {
        background: #293340;
        color: #f8f8f2;
        border-radius: 0px;
        padding: 20px;
    }
</style>
@endpush

@push('script')
    <script>
        'use strict';
        $('.gk').on('click',function () { 
            $.ajax({
                url: "{{ route('user.generate.key') }}",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    if(data.success){
                        toast('success',data.success);
                        $('.old-key').text(data.key);
                        $('#api_key').find('.key').val(data.key);
                        $('#api_key').modal('show');
                    }
                }
            });
        })
    </script>
@endpush