@extends('layouts.admin')

@section('title')
   @langg('Balance Transfer Settings')
@endsection

@section('breadcrumb')
 <section class="section">
    <div class="section-header">
        <h1>@langg('Balance Transfer Settings')</h1>
    </div>
</section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="" method="POST" class="row">
                        @csrf
                        <div class="form-group col-md-12">
                            <label>@langg('Balance Transfer Status')</label>
                            <select name="trans_status" class="form-control">
                                <option value="1" {{$gs->trans_status == 1 ? 'selected':''}}>@langg('Enable')</option>
                                <option value="0" {{$gs->trans_status == 0 ? 'selected':''}}>@langg('Disable')</option>
                            </select>
                        </div>
               
                        <div class="form-group col-md-6">
                            <label>@langg('Fixed Charge')</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="transfer_fix_charge" placeholder="@lang('e.g : 10')" required value="{{old('transfer_fix_charge',round($gs->transfer_fix_charge))}}">
                                <div class="input-group-append">
                                    <span class="input-group-text">{{$gs->curr_code}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>@langg('Percent Charge')</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="transfer_percent_charge" placeholder="@lang('e.g : 2')" required value="{{old('transfer_percent_charge	',$gs->transfer_percent_charge	)}}">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>@langg('Minmum transfer amount')</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="min_trans" required value="{{old('min_trans',round($gs->min_trans))}}">
                                <div class="input-group-append">
                                    <span class="input-group-text">{{$gs->curr_code}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>@langg('Maximum transfer amount')</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="max_trans" required value="{{old('max_trans',round($gs->max_trans))}}">
                                <div class="input-group-append">
                                    <span class="input-group-text">{{$gs->curr_code}}</span>
                                </div>
                            </div>
                        </div>

                    
                        <div class="form-group col-md-12 text-right">
                           <button class="btn btn-primary" type="submit">@langg('Submit')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
