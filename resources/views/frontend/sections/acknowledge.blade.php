<section class="choose-section pt-100 pb-50">
    <div class="container">
        <div class="row gy-5 justify-content-between align-items-center">
            <div class="col-lg-7 col-xxl-8">
                <div class="about--content">
                    <div class="section-header mb-4">
                        <h6 class="section-header__subtitle">@lang(@$section->content->title)</h6>
                        <h2 class="section-header__title">@lang(@$section->content->heading)</h2>
                        <p>
                            @lang(@$section->content->sub_heading)
                        </p>
                    </div>
                    <p class="about-txt m-0 mb-4">
                        @lang(@$section->content->short_details)
                    </p>
                    <a href="{{url(@$section->content->button_url)}}" class="cmn--btn"> @lang(@$section->content->button_name) <span class="round-effect">
                            <i class="fas fa-long-arrow-alt-right"></i>
                        </span></a>
                </div>
            </div>
            <div class="col-lg-5 col-xxl-4 d-none d-lg-block">
                <div class="about-thumb">
                    <img src="{{getPhoto(@$section->content->image)}}" alt="about">
                </div>
            </div>
        </div>
    </div>
</section>