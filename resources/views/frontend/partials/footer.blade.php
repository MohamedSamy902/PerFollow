@php
$socials = App\Models\SiteContent::where('slug','social')->first();
$policies = App\Models\SiteContent::where('slug','policies')->first();
@endphp

<footer>
    <div class="container">
        <div class="footer-top">
            <div class="footer-wrapper">
                <div class="footer-logo logo-white">
                    <a href="{{url('/')}}">
                        <img src="{{getPhoto($gs->header_logo)}}" alt="logo" />
                    </a>
                </div>
       
                <div class="footer-links">
                    <h5 class="title">@lang('Menu')</h5>
                    <ul>
                        @foreach (json_decode($gs->menu) as $item)
                        <li>
                           <a target="{{$item->target == 'self' ? '':'_blank'}}" href="{{url($item->href)}}">{{__($item->title)}}</a>
                        </li>
                      @endforeach
                    </ul>
                </div>
                <div class="footer-links mobile-second-item">
                    <h5 class="title">@lang('Pages')</h5>
                    <ul>
                        <li>
                            <a href="{{route('faq')}}">@lang('Frequently Asked Questions')</a>
                        </li>
                        @foreach (DB::table('pages')->where('lang',app()->currentLocale())->get() as $item)
                            @if ($item->slug != 'about')
                                <li>
                                    <a href="{{route('pages',[$item->id,$item->slug])}}">@lang($item->title)</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="footer-links mobile-second-item">
                    <h5 class="title">@lang('Terms and Policies')</h5>
                    <ul>
                        @foreach ($policies->sub_content as $key=> $item)
                        @if (app()->currentLocale() == $item->lang)
                            <li>
                                <a href="{{route('terms.details',[$key,Str::slug($item->title)])}}">{{__($item->title)}}</a>
                            </li>
                        @endif
                    @endforeach
                    </ul>
                </div>
                <div class="footer-comunity">
                    <h5 class="title">@langg('Community')</h5>
                    <ul class="social-icons justify-content-start mt-0 mb-4">
                        @foreach ($socials->sub_content as $item)
                        <li>
                            <a target="_blank" href="{{@$item->url}}"><i class="{{@$item->icon}}"></i></a>
                        </li>
                        @endforeach
                    </ul>
                    <p>
                        @langg('Stay connected with us')
                    </p>
                </div>
            </div>
        </div>
        <div class="footer-copyright text-center mt-auto">
            &copy; @langg('All Right Reserved by') <a href="{{url('/')}}" class="text--base">{{$gs->title}}</a>
        </div>
    </div>
</footer>