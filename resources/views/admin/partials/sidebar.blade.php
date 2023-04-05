<aside id="sidebar-wrapper">

  <ul class="sidebar-menu mb-5">
      <li class="menu-header">@langg('Dashboard')</li>
      <li class="nav-item {{menu('admin.dashboard')}}">
        <a href="{{route('admin.dashboard')}}" class="nav-link"><i class="fas fa-fire"></i><span>@langg('Dashboard')</span></a>
      </li>


      @if (access('transactions'))
      <li class="nav-item {{menu('admin.transactions')}}">
        <a href="{{route('admin.transactions')}}" class="nav-link"><i class="fas fa-exchange-alt"></i><span>@langg('Transaction Report')</span></a>
      </li>
      @endif

      <li class="menu-header">@langg('Manage')</li>
      @if (access('manage user'))
      <li class="nav-item {{menu(['admin.user.index','admin.user.details'])}}">
        <a href="{{route('admin.user.index')}}" class="nav-link"><i class="fas fa-users"></i><span>@langg('Manage User')</span></a>
      </li>
      @endif

      @if(access('manage currency'))
      <li class="nav-item {{menu('admin.currency.index')}}">
        <a href="{{route('admin.currency.index')}}" class="nav-link"><i class="fas fa-coins"></i><span>@langg('Manage Currency')</span></a>
      </li>
      @endif
 
      @if(access('manage country'))
      <li class="nav-item {{menu('admin.country.index')}}">
        <a href="{{route('admin.country.index')}}" class="nav-link"> <i class="fas fa-globe"></i><span>@langg('Manage Country')</span></a>
      </li>
      @endif

      @if (access('manage category'))
      <li class="nav-item {{menu(['admin.category'])}}">
        <a href="{{route('admin.category')}}" class="nav-link"><i class="fas fa-layer-group"></i><span>@langg('Manage Category')</span></a>
      </li>
      @endif
      
      @if (access('manage provider'))
      <li class="nav-item {{menu(['admin.provider'])}}">
        <a href="{{route('admin.provider')}}" class="nav-link"><i class="fas fa-network-wired"></i><span>@langg('Manage Provider')</span></a>
      </li>
      @endif

      @if (access('manage transfer'))
      <li class="nav-item {{menu('admin.manage.transfer')}}">
        <a href="{{route('admin.manage.transfer')}}" class="nav-link"> <i class="fas fa-random"></i><span>@langg('Manage Transfer')</span></a>
      </li>
      @endif

      @if (access('manage referral'))
      <li class="nav-item {{menu('admin.referral')}}">
        <a href="{{route('admin.referral')}}" class="nav-link"> <i class="fas fa-hands-helping"></i><span>@langg('Manage Referral')</span></a>
      </li>
       @endif

      @if (access('api actions'))
      <li class="nav-item {{menu('admin.api.actions')}}">
        <a href="{{route('admin.api.actions')}}" class="nav-link"> <i class="fas fa-wrench"></i><span>@langg('API Actions')</span></a>
      </li> 
      @endif

      @if (access('manage order'))
      <li class="nav-item {{menu('admin.order.*')}}">
        <a href="{{route('admin.order.all')}}" class="nav-link"> <i class="fas fa-shopping-cart"></i><span>@langg('Manage Orders')</span></a>
      </li>
      @endif

      @if (access('order cron job'))
      <li class="nav-item {{menu('admin.cronjob')}}">
        <a href="{{route('admin.cronjob')}}" class="nav-link"> <i class="fas fa-clone"></i><span>@langg('Order Cron Job')</span></a>
      </li>
      @endif


      @if (access('manage service') || access('create service') || access('import service'))
         <li class="menu-header">@langg('Manage Services')</li>
         @if (access('manage service'))
        <li class="nav-item {{menu(['admin.service.category','admin.services'])}}">
          <a href="{{route('admin.service.category')}}" class="nav-link"><i class="fas fa-server"></i><span>@langg('Service Category')</span></a>
        </li>

        <li class="nav-item {{menu(['admin.service.all'])}}">
          <a href="{{route('admin.service.all')}}" class="nav-link"><i class="fas fa-align-left"></i><span>@langg('All Services')</span></a>
        </li>
        @endif
        @if (access('add service'))
        <li class="nav-item {{menu(['admin.service.create'])}}">
          <a href="{{route('admin.service.create')}}" class="nav-link"><i class="fas fa-plus-circle"></i><span>@langg('Create Service')</span></a>
        </li>
        @endif
        @if (access('import service'))
        <li class="nav-item {{menu(['admin.import.service'])}}">
          <a href="{{route('admin.import.service')}}" class="nav-link"><i class="fas fa-file-import"></i><span>@langg('Import Service')</span></a>
        </li>
        @endif
      @endif

      <li class="menu-header">@langg('Staff and Role')</li>

      @if(access('manage role'))
      <li class="nav-item {{menu('admin.role*')}}">
        <a href="{{route('admin.role.manage')}}" class="nav-link"><i class="fas fa-user-tag"></i><span>@langg('Manage Role')</span></a>
      </li>
      @endif
      @if(access('manage staff'))
      <li class="nav-item {{menu('admin.staff*')}}">
        <a href="{{route('admin.staff.manage')}}" class="nav-link"><i class="fas fa-user-shield"></i><span>@langg('Manage Staff')</span></a>
      </li>
      @endif

      <li class="menu-header">@langg('Payment')</li>

        @if(access('manage payment gateway'))
        <li class="nav-item {{menu('admin.gateway')}}"><a class="nav-link" href="{{route('admin.gateway')}}"><i class="fas fa-credit-card"></i><span>@langg('Payment Gateways')</span></a>
        </li>
        @endif
        @if(access('manage deposit'))
        <li class="nav-item {{menu('admin.deposit')}}"><a class="nav-link {{$pending_deposits > 0 ? 'beep beep-sidebar':""}}" href="{{route('admin.deposit')}}"><i class="fas fa-money-bill"></i><span>@langg('Manage Deposits')</span></a>
        </li>
        @endif
          
       

      <li class="menu-header">@langg('General')</li>
      @if(access('general setting') || access('general settings logo favicon'))
      <li class="nav-item dropdown {{menu(['admin.gs*','admin.cookie'])}}">
        <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cog"></i><span>@langg('General Settings')</span></a>
        <ul class="dropdown-menu">
          @if(access('general setting'))
          <li class="{{menu('admin.gs.site.settings')}}"><a class="nav-link" href="{{route('admin.gs.site.settings')}}">@langg('Site Settings')</a></li>
          @endif
          @if(access('general settings logo favicon'))
          <li class="{{menu('admin.gs.logo')}}"><a class="nav-link" href="{{route('admin.gs.logo')}}">@langg('Logo & Favicon')</a></li>
          @endif
          @if(access('manage cookie'))
          <li class="{{menu('admin.cookie')}}"><a class="nav-link" href="{{route('admin.cookie')}}">@langg('Cookie Concent')</a></li>
          @endif
        </ul>
      </li>
      @endif
      @if(access('manage page') || access('menu builder') || access('site contents') ||  access('manage blog-category') ||  access('manage blog') || access('seo settings'))
      <li class="nav-item dropdown {{menu(['admin.front*','admin.page*','admin.frontend*','admin.bcategory*','admin.blog*','admin.seo-setting*'])}}">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-th"></i> <span>@langg('Frontend Setting')</span></a>
        <ul class="dropdown-menu">

          @if (access('manage page'))
          <li class="{{menu('admin.page.index')}}"><a class="nav-link" href="{{ route('admin.page.index') }}">@langg('Pages Settings')</a></li>
          @endif
          
          @if (access('menu builder'))
          <li class="{{menu('admin.front.menu')}}"><a class="nav-link" href="{{route('admin.front.menu')}}">@langg('Menu Builder')</a></li>
          @endif

          @if (access('site contents'))
          <li class="{{menu(['admin.frontend.index','admin.frontend.edit'])}}"><a class="nav-link" href="{{route('admin.frontend.index')}}">@langg('Site Contents')</a></li>
          @endif

          @if (access('manage blog-category'))
          <li class="{{menu('admin.bcategory.index')}}"><a class="nav-link" href="{{route('admin.bcategory.index')}}">@langg('Blog Category')</a></li>
          @endif

          @if (access('manage blog'))
          <li class="{{menu(['admin.blog.index','admin.blog.create','admin.blog.edit'])}}"><a class="nav-link" href="{{route('admin.blog.index')}}">@langg('Manage Blog')</a></li>
          @endif

          @if (access('seo settings'))
          <li class="{{menu('admin.seo-setting.index')}}"><a class="nav-link" href="{{route('admin.seo-setting.index')}}">@langg('Seo Settings')</a></li>
          @endif
        </ul>
      </li>
      @endif

      @if(access('email templates') || access('email config') || access('group email'))
      <li class="nav-item dropdown {{menu('admin.mail*')}}">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-envelope-square"></i> <span>@langg('Email Settings')</span></a>
        <ul class="dropdown-menu">
          @if(access('email templates'))
          <li class="{{menu('admin.mail.index')}}"><a class="nav-link" href="{{route('admin.mail.index')}}">@langg('Email Templates')</a></li>
          @endif
          @if(access('email config'))
          <li class="{{menu('admin.mail.config')}}"><a class="nav-link" href="{{route('admin.mail.config')}}">@langg('Email Config')</a></li>
          @endif
          @if(access('group email'))
          <li class="{{menu('admin.mail.group.show')}}"><a class="nav-link" href="{{route('admin.mail.group.show')}}">@langg('Group Emails')</a></li>
          @endif
        </ul>
      </li>
     
      @endif
      @if(access('sms gateways') || access('sms templates'))
      <li class="nav-item dropdown {{menu('admin.sms*')}}">
        <a href="#" class="nav-link has-dropdown"><i class="far fa-comment-alt"></i> <span>@langg('SMS Settings')</span></a>
        <ul class="dropdown-menu">
          @if (access('sms gateways'))
          <li class="{{menu('admin.sms.index')}}"><a class="nav-link" href="{{route('admin.sms.index')}}">@langg('SMS Gateway')</a></li>
          @endif

          @if (access('sms templates'))
          <li class="{{menu('admin.sms.templates')}}"><a class="nav-link" href="{{route('admin.sms.templates')}}">@langg('SMS Template')</a></li>
          @endif
        </ul>
      </li>
      @endif
    
      @if(access('manage language'))
      <li class="nav-item {{menu(['admin.language*'])}}">
        <a href="{{route('admin.language.index')}}" class="nav-link"><i class="fas fa-language"></i> <span>@langg('Manage Language')</span></a>
      </li>
      @endif

      @if(access('manage ticket'))
      <li class="nav-item dropdown {{menu('admin.ticket.manage')}}">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-ticket-alt"></i> <span>@langg('Support Tickets')  @if ($pending_user_ticket > 0) <small class="badge badge-primary mr-4">!</small> @endif</span></a>
        <ul class="dropdown-menu">
          <li class="{{url()->current() == url('admin/manage/tickets/user') ? 'active':''}}"><a class="nav-link {{$pending_user_ticket > 0 ? 'beep beep-sidebar':""}}" href="{{route('admin.ticket.manage','user')}}">@langg('User Tickets')</a></li>

        </ul>
      </li>
    @endif

    @if(access('system update'))
    <li class="nav-item {{menu('admin.update')}}">
      <a href="{{route('admin.update')}}" class="nav-link"><i class="fas fa-arrow-up"></i> <span>@lang('System Update')</span></a>
    </li>
    @endif

    <li class="nav-item {{menu('admin.clear.cache')}}">
      <a href="{{route('admin.clear.cache')}}" class="nav-link"><i class="fas fa-broom"></i> <span>@lang('Clear Cache')</span></a>
    </li>

    @if (admin()->id == 1)
    <li class="nav-item {{menu('admin-activation-form')}}">
      <a class="nav-link" href="{{route('admin-activation-form')}}"><i class="fas fa-check-circle"></i><span>@lang('System Activation')</span></a>
    </li>
    @endif
    
    <li class="nav-item mt-5">
      <h6 class="text-primary text-center"> @lang('Version') : {{sysVersion()}} </h6>
    </li>
    </ul>
</aside>