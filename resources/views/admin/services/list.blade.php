@extends('layouts.admin')
@section('title')
    @lang('List of Services')
@endsection
@section('breadcrumb')
 <section class="section">
    <div class="section-header d-flex flex-wrap justify-content-between">
      <h1 class="mb-1 mr-auto">@langg('Service Categories')</h1>
     
    </div>
</section>
@endsection
@section('content')
<div class="row justify-content-center">
    @forelse ($categories as $item)
    <div class="col-md-6 col-lg-6 col-xl-3 currency--card">
      <div class="card card-primary">
        <div class="card-header">
          <h4 data-toggle="tooltip" title="{{$item->name}}"> {{Str::limit($item->name,30)}}</h4>
        </div>
        <div class="card-body">
          <ul class="list-group mb-3">
            <li class="list-group-item d-flex justify-content-between">@langg('Total services :')
              <span>{{$item->services_count}}</span>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center">@langg('Status :')
                @if ($item->status == 1)
                <span class="badge badge-success">@langg('active')</span>
                @else
                <span class="badge badge-success">@langg('inactive')</span>
                @endif
            </li>
           
          </ul>
          
          <a href="{{route('admin.services',$item->slug)}}" class="btn btn-primary btn-block "><i class="fas fa-forward"></i> @langg('See Services')</a>  
          
        </div>
      </div>
    </div>
    @empty
        <h4 class="text-center">@langg('No service category found')</h4>
    @endforelse
    @if ($categories->hasPages())
    <div class="col-md-12 d-flex justify-content-center my-4">
        {{$categories->links()}}
    </div>
        
    @endif
</div>


@endsection

