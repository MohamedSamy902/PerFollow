@php
$socials = App\Models\SiteContent::where('slug','social')->first();
@endphp
<header>
  <div class="navbar-top">
      <div class="container">
          <div class="d-flex flex-wrap justify-content-evenly justify-content-md-between">
              <div class="d-flex flex-wrap align-items-center">
                  <ul class="social-icons py-1 py-md-0 me-md-auto">
                    @foreach ($socials->sub_content as $item)
                    <li>
                        <a target="_blank" href="{{@$item->url}}"><i class="{{@$item->icon}}"></i></a>
                    </li>
                     @endforeach
                  </ul>
                  <div class="change-language d-md-none">
                      <select class="language-bar">
                        @foreach (DB::table('languages')->get() as $item)
                        <option value="{{route('lang.change',$item->code)}}" {{session('lang') == $item->code ? 'selected':''}}>@langg($item->language)</option>
                        @endforeach
                      </select>
                  </div>
              </div>
              <ul class="contact-bar py-1 py-md-0">
                <li>
                    <a href="Tel:{{$contact->content->phone}}">{{$contact->content->phone}}</a>
                </li>
                <li>
                    <a href="Mailto:{{$contact->content->email}}">{{$contact->content->email}}</a>
                </li>
                 
                  <li>
                    <div class="change-language d-none d-md-block">
                      <select class="language-bar form-control shadow-none" onChange="window.location.href=this.value">
                          @foreach (DB::table('languages')->get() as $item)
                            <option value="{{route('lang.change',$item->code)}}" {{session('lang') == $item->code ? 'selected':''}}>@langg($item->language)</option>
                          @endforeach
                      </select>
                    </div>
                </li>
              </ul>
          </div>
      </div>
  </div>
  <div class="navbar-bottom">
      <div class="container">
          <div class="navbar-wrapper">
              <div class="logo me-auto">
                  <a href="{{url('/')}}">
                      <img src="{{getPhoto($gs->header_logo)}}" alt="logo" />
                  </a>
              </div>
              <div class="nav-toggle d-lg-none">
                  <span></span>
                  <span></span>
                  <span></span>
              </div>
              <div class="nav-menu-area">
                  <div class="menu-close text--danger d-lg-none">
                      <i class="fas fa-times"></i>
                  </div>
                  <ul class="nav-menu">
                    <li>
                        <a href="{{route('user.dashboard')}}">@langg('Dashboard')</a>
                    </li>
                    <li>
                        <a href="#0">@langg('Orders')</a>
                        <ul class="sub-nav">
                           
                            <li>
                                <a href="{{route('user.order.new')}}">@langg('New Order')</a>
                            </li>
                            <li>
                                <a href="{{route('user.mass.order.new')}}">@langg('Mass Order')</a>
                            </li>
                            <li>
                                <a href="{{route('user.order.history')}}">@langg('Order history')</a>
                            </li>
                            
                        </ul>
                    </li>
                   
                    <li>
                       <a  href="{{route('user.services')}}">@langg('Services')</a>
                    </li>

                    <li>
                        <a href="#0">@langg('Deposit')</a>
                        <ul class="sub-nav">
                           
                            <li>
                                <a href="{{route('user.deposit.index')}}">@langg('New Deposit')</a>
                            </li>
                            <li>
                                <a href="{{route('user.deposit.history')}}">@langg('Deposit History')</a>
                            </li>
                            
                        </ul>
                    </li>

                    @if ($gs->trans_status != 0)
                    <li>
                        <a href="#0">@langg('Balance Transfer')</a>
                        <ul class="sub-nav">
                            <li>
                                <a href="{{route('user.transfer.balance')}}">@langg('New Transfer')</a>
                            </li>
                            <li>
                                <a href="{{route('user.transfer.history')}}">@langg('Transfer History')</a>
                            </li>
                            
                        </ul>
                    </li>
                    @endif

                    <li>
                        <a  href="{{route('user.transactions')}}">@langg('Transactions')</a>
                     </li>
                    
                  </ul>
              </div>
              <div class="header-user-toggle">
                <a href="#0" class="toggle-user-toggle-btn">
                    <img src="{{getPhoto(auth()->user()->photo)}}" alt="user">
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="{{route('user.api.doc')}}">
                        <i class="fas fa-file-alt"></i>
                        @langg('API Doc')
                    </a>
                    
                    <a class="dropdown-item" href="{{route('user.referrals')}}">
                        <i class="fas fa-hands-helping fa-sm"></i>
                        @langg('Referrals')
                    </a>
                    
                    <a class="dropdown-item" href="{{route('user.profile')}}">
                        <i class="fas fa-user fa-sm"></i>
                        @langg('Profile settings')
                    </a>
                    <a class="dropdown-item" href="{{route('user.change.pass')}}">
                        <i class="fas fa-cogs fa-sm"></i>
                        @langg('Change Password')
                    </a>
                    <a class="dropdown-item" href="{{route('user.two.step')}}">
                        <i class="fas fa-lock fa-sm"></i>
                        @langg('Two Factor')
                    </a>
                    <a class="dropdown-item" href="{{route('user.ticket.index')}}">
                        <i class="fas fa-ticket-alt fa-sm"></i>
                        @langg('Support Ticket')
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{route('user.logout')}}">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        @langg('Log out')
                    </a>
                </div>
            </div>
          </div>
      </div>
  </div>
</header>




