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
                    @foreach (json_decode($gs->menu) as $item)
                    <li>
                       <a target="{{$item->target == 'self' ? '':'_blank'}}" href="{{url($item->href)}}">{{__($item->title)}}</a>
                    </li>
                     @endforeach
                      <li>
                        @auth
                        <div class="btn__grp ms-lg-3">
                            <a href="{{route('user.dashboard')}}" class="cmn--btn">@lang('Dashboard')</a>
                            <a href="{{route('user.logout')}}" class="cmn--btn btn-outline">@lang('Logout')</a>
                        </div>
                        @else
                        <div class="btn__grp ms-lg-3">
                            <a href="{{route('user.login')}}" class="cmn--btn">@lang('Login')</a>
                            <a href="{{route('user.register')}}" class="cmn--btn btn-outline">@lang('Register')</a>
                        </div>
                        @endauth
                      </li>
                  </ul>
              </div>
          </div>
      </div>
  </div>
</header>




