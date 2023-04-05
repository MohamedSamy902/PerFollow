<section class="about-section pt-100 pb-50">
    <div class="container">
        <div class="row gy-5 justify-content-between align-items-center flex-wrap-reverse">
            <div class="col-lg-6 col-xl-5">
                <div class="about-thumb">
                    <img src="{{getPhoto(@$section->content->image)}}" alt="about">
                </div>
            </div>
            <div class="col-lg-6 col-xl-7 col-xxl-6">
                <div class="about--content">
                    <div class="section-header mb-4">
                        <h6 class="section-header__subtitle">@lang(@$section->content->title)</h6>
                        <h2 class="section-header__title">@lang(@$section->content->heading)</h2>
                        <p class="mt-0 pt-sm-2">
                            @lang(@$section->content->short_details)
                        </p>
                    </div>
                    
                    <a href="{{url(@$section->content->button_url)}}" class="cmn--btn mt-sm-3">@lang(@$section->content->button_name) <span class="round-effect">
                            <i class="fas fa-long-arrow-alt-right"></i>
                        </span></a>
                </div>
                @if (is_array($section->sub_content))
                <div class="border-top mt-4">
                    <div class="counter-area">
                        @foreach ($section->sub_content as $item)
                        <div class="counter-item">
                            <div class="counter-thumb">
                                <img src="{{getPhoto($item->image)}}" alt="about">
                            </div>
                            <div class="counter-content">
                                <div class="counter-header">
                                    <h4 class="title">{{$item->count}}</h4>
                                </div>
                                <div class="subtitle">@lang($item->title)</div>
                            </div>
                        </div>
                            
                        @endforeach
                       
                    </div>
                </div>
                    
                @endif
            </div>
        </div>
    </div>
</section>