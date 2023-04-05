@extends('layouts.admin')

@section('title')
   @langg('Manage Country')
@endsection

@section('breadcrumb')
 <section class="section">
    <div class="section-header d-flex flex-wrap justify-content-between">
        <h1 class="mt-2">@langg('Country List')</h1>
        <form action="">
            <div class="input-group has_append mt-2">
              <input type="text" class="form-control" placeholder="@langg('Country Name')" name="search" value="{{$search ?? ''}}"/>
              <div class="input-group-append">
                  <button class="input-group-text bg-primary border-0"><i class="fas fa-search text-white"></i></button>
              </div>
            </div>
          </form>
     
    </div>
</section>
@endsection

@section('content')
<div class="row">

    <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
           
            <div class="card-body text-center">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>@langg('Sl')</th>
                            <th>@langg('Flag')</th>
                            <th>@langg('Name')</th>
                            <th>@langg('Country Code')</th>
                            <th>@langg('Dial Code')</th>
                            <th>@langg('Status')</th>
                            <th>@langg('Action')</th>
                        </tr>
                        @forelse ($countries as $key => $country)
                            <tr>
                                <td data-label="@langg('Sl')">{{ $key + $countries->firstItem() }}</td>
                    
                                <td data-label="@langg('Name')">
                                    <img src="{{$country->flag}}" width="50px" height="45px">
                                </td>
                                <td data-label="@langg('Name')">
                                    {{ $country->name }}
                                </td>
                                <td data-label="@langg('Country Code')">
                                    {{ $country->code }}
                                </td>
                                <td data-label="@langg('Dial Code')">
                                    {{ $country->dial_code }}
                                </td>

                                <td data-label="@langg('Status')">
                                    @if($country->status == 1)
                                        <span class="badge badge-success">@langg('Active')</span>
                                    @else
                                        <span class="badge badge-warning">@langg('Deactive')</span>
                                    @endif
                                </td>

                                <td data-label="@langg('Action')">
                                    <div class="d-flex flex-wrap align-items-center justify-content-end justify-content-lg-center">
                                        @if ($country->status == 1)
                                        <button class="btn btn-danger reject m-1 btn-sm c_status" data-url="{{route('admin.country.update.status',$country->id)}}" data-status="{{$country->status}}">@langg('Deactive')</button>
                                        @else
                                        <button type="button" class="btn btn-success reject m-1 btn-sm c_status" data-url="{{route('admin.country.update.status',$country->id)}}" data-status="{{$country->status}}">@langg('Active')</button>
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
            @if ($countries->hasPages())
                <div class="card-footer">
                    {{ $countries->links('admin.partials.paginate') }}
                </div>
            @endif
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-body text-center">
                    <h5 class="msg mt-3"></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">@langg('Close')</button>
                    <button type="submit" class="btn btn-primary">@langg('Confirm')</button>
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
            if(status == 1) status_text = '@langg("Are you sure to deactive this country?")';
            else status_text = '@langg("Are you sure to active this country?")';
            $('#statusModal').find('.msg').text(status_text);
            $('#statusModal').find('form').attr('action', route);
            $('#statusModal').modal('show');
        });

       
    </script>
@endpush