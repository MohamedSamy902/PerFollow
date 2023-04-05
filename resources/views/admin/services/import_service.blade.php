@extends('layouts.admin')

@section('title')
    @lang('Import Service')
@endsection

@section('breadcrumb')
 <section class="section">
    <div class="section-header d-flex flex-wrap justify-content-between">
      <h1 class="mb-1 mr-auto">@langg('Import Service')</h1>
    </div>
</section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="" class="row" method="POST">
                        @csrf
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('Select Category')</label>
                                <select class="form-control category_id"  name="category_id" required>
                                    <option value="" selected>@langg('Select Category')</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id  }}">@lang($category->name)</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('Increase Price (%)')</label>
                                <input type="text" class="form-control" name="price_inc" required>
                            </div>
                            <hr>
                        </div>
                      
                        <div class="form-group col-md-4">
                            <input class="form-control search" type="text" placeholder="@langg('Search')">
                        </div>
                        <div class="form-group col-md-8 text-right">
                            <button class="btn btn-primary btn-lg" type="submit">@langg('Submit')</button>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>@langg('Name')</th>
                                            <th>@langg('Category')</th>
                                            <th>@langg('Limit')</th>
                                            <th>@langg('Rate/1k')</th>
                                        </tr>
                                    </thead>  
                                    <tbody class="tbody">
                                        <tr>
                                            <td class="text-center" colspan="12">@langg('No data')</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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
        'use strict';
        $(document).ready(function () {
            $('.category_id').select2({
             selectOnClose: true
            });

            var elements;
            $(document).on('change','.provider',function () { 
                var provider_id = $(this).val();
                $('#loader').modal('show');
                $.ajax({
                    url: "{{ route('admin.get.service') }}",
                    type: "GET",
                    data: {
                        provider_id: provider_id,
                        import: true,
                    },
                    success: function (data) {
                        $('.tbody').html(data);
                        elements = $('.elements');
                        $('#loader').modal('hide');
                    }
                });
            })

            
            $(document).on('input','.search',function(){
                
                var search = $(this).val().toUpperCase();
                var match = elements.filter(function (idx, elem) {
                    return $(elem).text().trim().toUpperCase().indexOf(search) >= 0 ? elem : null;
                }).sort();
                var content = $('.tbody');
                if (match.length == 0) {
                    content.html('<td class="text-center" colspan="12">@langg('No data')</td>');
                }else{
                    content.html(match);
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