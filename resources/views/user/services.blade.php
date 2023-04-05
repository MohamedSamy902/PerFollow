@extends('layouts.user')

@section('title')
    @langg('Services')
@endsection

@section('content')
<section class="user-panel pt-50 pb-100">
    <div class="container">
        <div class="card">
            <div class="card-header bg-white border-0 pb-0 pt-3">
                <div class="row g-3 justify-content-end">
                    <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                            <input type="text" name="name" id="name" class="form-control" placeholder="@lang("Service ID/Name")">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                            <select class="form-control" onChange="window.location.href=this.value">
                                <option value="{{filter('category','')}}" selected>@langg('Filter By Category')</option>
                                @foreach ($categories as $item)
                                <option value="{{filter('category',$item->id)}}" {{request('category') == $item->id ? 'selected':''}}>{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="dashboard--content-item">
                            <div class="table-responsive">
                                <table class="table bg--body">
                                    <thead>
                                        <tr>
                                          <th>@langg('SERVICE ID')</th>
                                          <th>@langg('SERVICE')</th>
                                          <th>@langg('RATE/1K')</th>
                                          <th>@langg('MIN')</th>
                                          <th>@langg('MAX')</th>
                                          <th>@langg('DETAILS')</th>
                                         </tr>
                                    </thead>
                                    <tbody class="tbody">
                                       
                                        @forelse ($services as $item)
                                            <tr>
                                               
                                                <td data-label="@langg('SERVICE ID')">
                                                    <div>
                                                        {{ $item->id }}
                                                    </div>
                                                </td>
                                              
                                                <td data-label="@langg('SERVICE')" data-bs-toggle="tooltip" title="{{$item->title}}">
                                                    <div class="max-360px mx-auto">
                                                        {{ Str::limit($item->title) }}
                                                    </div>
                                                </td>
                                         
                                                <td data-label="@langg('RATE/1K')">
                                                    <div class="text--success">
                                                        {{ number_format($item->price,4) }} {{$gs->curr_code}}
                                                    </div>
                                                </td>
                                                <td data-label="@langg('MIN')">
                                                    <div>
                                                        {{ $item->min_amount }}
                                                    </div>
                                                </td>
                                                <td data-label="@langg('MAX')">
                                                    <div>
                                                        {{ $item->max_amount }}
                                                    </div>
                                                </td>
                                               
                                                
                                                <td data-label="@langg('DETAILS')">
                                                    <button class="btn btn-primary btn-sm details" data-details="{{$item->description}}">@langg('Details')</button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="12">
                                                    <div class="text-center">
                                                        @langg('No result found')
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($services->hasPages())
                <div class="card-footer bg-white border-0 pb-3">
                    {{ $services->links() }}
                </div>
            @endif
           
        </div>
    </div>
    <div id="loader" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <div class="lds-facebook text-center"><div></div><div></div><div></div></div>
        </div>
    </div>


    <div class="modal fade" id="details-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@langg('Details')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="details"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@langg('Close')</button>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@push('script')
    <script>
        'use strict';
        $('#name').on('input keyup',function(){
            var name = $(this).val();
            var data = {name:name};
            $('#loader').modal('show');
            setTimeout(() => {
                $.get("{{route('user.get.services')}}", data,
                    function (res) {
                       $('.tbody').html(res) 
                       $('#loader').modal('hide');
                       $('#name').focus() 
                    },
                );
            }, 800);
        });

        $('.details').on('click',function(){
            var details = $(this).data('details');
            $('#details').text(details);
            $('#details-modal').modal('show');
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