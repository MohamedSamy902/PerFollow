<section class="banner-section overflow-hidden vintage-banner">
    <div class="container">
        <div class="banner-wrapper">
            <div class="banner-content">
                <h6 class="section-header__subtitle">@lang(@$section->content->title)</h6>
                <h1 class="title">@lang(@$section->content->heading)</h1>
                <p class="text">
                   @lang(@$section->content->sub_heading)
                </p>
                <div class="btn__grp">
                    <a href="{{url(@$section->content->button_1_url)}}" class="cmn--btn me-4">@lang(@$section->content->button_1_name) <span class="round-effect">
                            <i class="fas fa-long-arrow-alt-right"></i>
                        </span></a>
                    
                </div>
            </div>
            <div class="banner-thumb">
                <img src="{{getPhoto(@$section->content->image)}}" alt="banner">
            </div>
        </div>
    </div>
</section>