@extends('layouts.admin')
@section('title')
    @langg('Admin Dashboard')
@endsection
@section('breadcrumb')
<section class="section">
    <div class="section-header">
        <h1>@langg('Dashboard')</h1>
    </div>
</section>
@endsection
@section('content')

    @if (access('dashboard info'))
    <div class="row">
        <div class="col-md-12 mb-2">
            <h5>@langg('Basic Statistics')</h5>
        </div>
       <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
           <div class="card card-statistic-1">
               <div class="card-icon bg-primary">
                   <i class="far fa-user"></i>
               </div>
               <div class="card-wrap">
                   <div class="card-header">
                       <h4>@langg('Total User')</h4>
                   </div>
                   <div class="card-body">
                      {{$totalUser}}
                   </div>
               </div>
           </div>
       </div>
       <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
           <div class="card card-statistic-1">
               <div class="card-icon bg-primary">
                   <i class="fas fa-network-wired"></i>
               </div>
               <div class="card-wrap">
                   <div class="card-header">
                       <h4>@langg('Total Provider')</h4>
                   </div>
                   <div class="card-body">
                      {{$totalProvider}}
                   </div>
               </div>
           </div>
       </div>
       <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
           <div class="card card-statistic-1">
               <div class="card-icon bg-primary">
                   <i class="fas fa-align-left"></i>
               </div>
               <div class="card-wrap">
                   <div class="card-header">
                       <h4>@langg('Total Services')</h4>
                   </div>
                   <div class="card-body">
                      {{$totalServices}}
                   </div>
               </div>
           </div>
       </div>
       <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
           <div class="card card-statistic-1">
               <div class="card-icon bg-primary">
                   <i class="fas fa-shopping-cart"></i>
               </div>
               <div class="card-wrap">
                   <div class="card-header">
                       <h4>@langg('Total Orders')</h4>
                   </div>
                   <div class="card-body">
                      {{$totalOrders}}
                   </div>
               </div>
           </div>
       </div>
     
       <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
           <div class="card card-statistic-1">
               <div class="card-icon bg-primary">
                <i class="fas fa-coins"></i>
               </div>
               <div class="card-wrap">
                   <div class="card-header">
                       <h4>@langg('Total Currency')</h4>
                   </div>
                   <div class="card-body">
                      {{$totalCurrency}}
                   </div>
               </div>
           </div>
       </div>
      
       <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
           <div class="card card-statistic-1">
               <div class="card-icon bg-primary">
                <i class="fas fa-user-tag"></i>
               </div>
               <div class="card-wrap">
                   <div class="card-header">
                       <h4>@langg('Total Role')</h4>
                   </div>
                   <div class="card-body">
                      {{$totalRole}}
                   </div>
               </div>
           </div>
       </div>
       <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
           <div class="card card-statistic-1">
               <div class="card-icon bg-primary">
                <i class="far fa-user"></i>
               </div>
               <div class="card-wrap">
                   <div class="card-header">
                       <h4>@langg('Total Staff')</h4>
                   </div>
                   <div class="card-body">
                      {{$totalStaff}}
                   </div>
               </div>
           </div>
       </div>
      
       <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
           <div class="card card-statistic-1">
               <div class="card-icon bg-primary">
                 <i class="fas fa-file-invoice-dollar"></i>
               </div>
               <div class="card-wrap">
                   <div class="card-header">
                       <h4>@langg('Default Currency')</h4>
                   </div>
                   <div class="card-body">
                    {{$gs->curr_code}} <sup class="text-danger">*</sup>
                   </div>
               </div>
           </div>
       </div>
   </div>

    <div class="row">
        <div class="col-sm-6 col-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-success text-white">
                    {{$gs->curr_sym}}
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                       <h4>@langg('Total Deposit')</h4>
                    </div>
                    <div class="card-body">
                        {{$gs->curr_sym}}{{$totalDeposit}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-12">
            <div class="card card-statistic-2">
                <div class="card-icon shadow-primary bg-success text-white">
                   <i class="fa fa-hand-holding-usd"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                       <h4>@langg('Total profit from charges')</h4>
                    </div>
                    <div class="card-body">
                        {{$gs->curr_sym}}{{$totalProfit}}
                    </div>
                </div>
            </div>
        </div>
      
    </div>
    <div class="row">
        <div class="col-md-12 mb-2">
            <h5>@langg('Order Statistics')</h5>
        </div>
     
        <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium">{{$totalOrders}}</h2>
                            </div>
                            <h6 class="font-weight-normal mb-0">@langg('Total Orders')</h6>
                        </div>

                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <span class="text-primary"><i class="fas fa-shopping-cart d_icon"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium">{{@$order['completed']}}</h2>
                            </div>
                            <h6 class="font-weight-normal mb-0">@langg('Completed')</h6>
                        </div>

                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <span class="text-primary"><i class="fa fa-check d_icon"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium">{{@$order['processing']}}</h2>
                            </div>
                            <h6 class="font-weight-normal mb-0">@langg('Processing')</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <span class="text-primary"><i class="fas fa-exchange-alt d_icon"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium">{{@$order['pending']}}</h2>
                            </div>
                            <h6 class="font-weight-normal mb-0">@langg('Pending')</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <span class="text-primary"><i class="fas fa-hourglass-end d_icon"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium">{{@$order['progress']}}</h2>
                            </div>
                            <h6 class="font-weight-normal mb-0">@langg('In Progress')</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <span class="text-primary"><i class="fa fa-spinner d_icon"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium">{{@$order['partial']}}</h2>
                            </div>
                            <h6 class="font-weight-normal mb-0">@langg('Partial')</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <span class="text-primary"><i class="fas fa-adjust d_icon"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium">{{@$order['canceled']}}</h2>
                            </div>
                            <h6 class="font-weight-normal mb-0">@langg('Canceled')</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <span class="text-primary"><i class="fa fa-ban d_icon"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium">{{@$order['refunded']}}</h2>
                            </div>
                            <h6 class="font-weight-normal mb-0">@langg('Refunded')</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <span class="text-primary"><i class="fas fa-history d_icon"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="row">
        <div class="col-md-12 mb-2">
            <h5>@langg('Deposit Statistics')</h5>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium">{{@$deposit['totalDepositCount']}}</h2>
                            </div>
                            <h6 class="font-weight-normal mb-0">@langg('Total Deposit')</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <span class="text-primary"><i class="fas fa-money-check-alt d_icon"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium">{{@$deposit['completed']}}</h2>
                            </div>
                            <h6 class="font-weight-normal mb-0">@langg('Total Completed Deposit')</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <span class="text-primary"><i class="fa fa-check d_icon"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium">{{@$deposit['pending']}}</h2>
                            </div>
                            <h6 class="font-weight-normal mb-0">@langg('Total Pending Deposit')</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <span class="text-primary"><i class="fas fa-hourglass-end d_icon"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex d-lg-flex d-md-block align-items-center">
                        <div>
                            <div class="d-inline-flex align-items-center">
                                <h2 class="text-dark mb-1 font-weight-medium">{{@$deposit['rejected']}}</h2>
                            </div>
                            <h6 class="font-weight-normal mb-0">@langg('Total Rejected Deposit')</h6>
                        </div>
                        <div class="ml-auto mt-md-3 mt-lg-0">
                            <span class="text-primary"><i class="fa fa-ban d_icon"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
   @endif

   <div class="row">
       <div class="col-12 col-md-12 col-lg-12">
           <div class="card">
               <div class="card-header">
                   <h4>@langg('Recent Registered Users')</h4>
               </div>
               <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <tr>
                            <th>@langg('Name')</th>
                            <th>@langg('Email')</th>
                            <th>@langg('Country')</th>
                            <th>@langg('Status')</th>
                            <th>@langg('Action')</th>
                        </tr>
                        @forelse ($recentUsers as $key => $user)
                            <tr>
                                 <td data-label="@langg('Name')">
                                   {{$user->name}}
                                 </td>
                                 <td data-label="@langg('Email')">{{$user->email}}</td>
                                 <td data-label="@langg('Country')">{{$user->country}}</td>
                                 <td data-label="@langg('Status')">
                                    @if($user->status == 1)
                                        <span class="badge badge-success">@langg('active')</span>
                                    @elseif($user->status == 2)
                                         <span class="badge badge-danger">@langg('banned')</span>
                                    @endif
                                 </td>
                                 @if (access('edit user'))
                                 <td data-label="@langg('Action')">
                                     <a class="btn btn-primary btn-sm details" href="{{route('admin.user.details',$user->id)}}">@langg('Details')</a>
                                 </td>
                                 @else
                                 <td data-label="@langg('Action')">
                                   N/A
                                </td>
                                 @endif
                               
                            </tr>
                         @empty

                            <tr>
                                <td class="text-center" colspan="100%">@langg('No Data Found')</td>
                            </tr>

                        @endforelse
                    </table>
                  </div>
               </div>
           </div>
       </div>
   </div>

@endsection


