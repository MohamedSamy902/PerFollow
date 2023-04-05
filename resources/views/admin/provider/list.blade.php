@extends('layouts.admin')

@section('title')
   @langg('List of Providers')
@endsection

@section('breadcrumb')
 <section class="section">
    <div class="section-header d-flex flex-wrap justify-content-between">
      <h1 class="mb-1 mr-auto">@langg('List of Providers')</h1>
      <div class="d-flex flex-wrap ">
            <a href="javascript:void(0)" class="btn btn-primary mb-1 mr-3" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus"></i> @langg('Add New')</a>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="row justify-content-center">
    @forelse ($providers as $item)
    <div class="col-md-6 col-lg-6 col-xl-3 currency--card">
      <div class="card card-primary">
        <div class="card-header">
          <h4><i class="fas fa-coins"></i> {{$item->name}}</h4>
        </div>
        <div class="card-body">
          <ul class="list-group mb-3">
            <li class="list-group-item d-flex justify-content-between">@langg('Balance :')
              <button class="btn btn-sm btn-dark b_check" data-item="{{$item}}">@langg('Check')</button>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">@langg('Status :')
                @if ($item->status == 1)
                <span class="badge badge-success">@langg('active')</span>
                @else
                <span class="badge badge-success">@langg('inactive')</span>
                @endif
            </li>
           
          </ul>
          
          <a href="javascript:void(0)" class="btn btn-primary btn-block edit" data-item="{{$item}}"><i class="fas fa-edit"></i> @langg('Edit Provider')</a>  
          
        </div>
      </div>
    </div>
    @empty
        <h4 class="text-center">@langg('No providers found')</h4>
    @endforelse
</div>



<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{route('admin.provider.store')}}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@langg('Add Provider')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label >@langg('Provider Name')</label>
                        <input  class="form-control" type="text" name="name" placeholder="@langg('Provider Name')" required>
                    </div>
                    <div class="form-group">
                        <label >@langg('API Key')</label>
                        <input  class="form-control" type="text" name="api_key" placeholder="@langg('API Key')" required>
                    </div>
                    <div class="form-group">
                        <label >@langg('API URL')</label>
                        <input  class="form-control" type="text" name="api_url" placeholder="https://provider.com" required>
                    </div>

                    <div class="form-group">
                        <label >@langg('Status')</label>
                        <select class="form-control" name="status">
                            <option value="1">@langg('Active')</option>
                            <option value="0">@langg('Inactive')</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">@langg('Close')</button>
                    <button type="submit" class="btn btn-primary">@langg('Save')</button>
                </div>

            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{route('admin.provider.update')}}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@langg('Edit Provider')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label >@langg('Provider Name')</label>
                        <input  class="form-control" type="text" name="name" placeholder="@langg('Provider Name')" required>
                    </div>
                    <div class="form-group">
                        <label >@langg('API Key')</label>
                        <input  class="form-control" type="text" name="api_key" placeholder="@langg('API Key')" required>
                    </div>
                    <div class="form-group">
                        <label >@langg('API URL')</label>
                        <input  class="form-control" type="text" name="api_url" placeholder="https://provider.com" required>
                    </div>

                    <div class="form-group">
                        <label >@langg('Status')</label>
                        <select class="form-control" name="status">
                            <option value="1">@langg('Active')</option>
                            <option value="0">@langg('Inactive')</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-dismiss="modal">@langg('Close')</button>
                    <button type="submit" class="btn btn-primary">@langg('Update')</button>
                </div>

            </div>
        </form>
    </div>
</div>


@endsection

@push('script')
    <script>
        'use strict';
        $('.b_check').on('click',function () { 
            var item = $(this).data('item');
            $.ajax({
                url: "{{route('admin.provider.check.balance')}}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "key": item.api_key,
                    "action": "balance",
                    "url":item.api_url
                },
                success: function (data) {
                    if (data) {
                        confirm('Your balance is : '+data.balance+' '+data.currency);
                    } else {
                        confirm('@langg('Error')');
                    }
                }
            });
        })

        $('.edit').on('click',function () { 
            var item = $(this).data('item');
            $('#editModal').find('input[name="id"]').val(item.id);
            $('#editModal').find('input[name="name"]').val(item.name);
            $('#editModal').find('input[name="api_key"]').val(item.api_key);
            $('#editModal').find('input[name="api_url"]').val(item.api_url);
            $('#editModal').find('select[name="status"]').val(item.status);
            $('#editModal').modal('show');
        })


    </script>
@endpush