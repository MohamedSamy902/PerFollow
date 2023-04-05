<section class="faqs-section pt-50 pb-50">
    <div class="container">
        <div class="row gy-5 justify-content-between align-items-center flex-wrap-reverse">
            <div class="col-lg-6 col-xxl-5 d-none d-lg-block">
                <div class="about-thumb">
                    <img src="{{getPhoto(@$section->content->image)}}" alt="about">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about--content">
                    <div class="section-header">
                        <h6 class="section-header__subtitle">@lang(@$section->content->title)</h6>
                        <h2 class="section-header__title">@lang(@$section->content->heading)</h2>
                        <p>
                            @lang(@$section->content->sub_heading)
                        </p>
                    </div>
                    <div class="accordion-wrapper mb-4 pb-md-4">
                        @if (is_array($section->sub_content))
                            @foreach ($section->sub_content as $key => $item)
                                @if ($key <= 5)
                                <div class="accordion-item @if($loop->first) active open @endif">
                                    <div class="accordion-title">
                                        <h5 class="title">
                                           @lang($item->question)
                                        </h5>
                                        <span class="right-icon"></span>
                                    </div>
                                    <div class="accordion-content">
                                        <p>
                                           @lang($item->answer)
                                        </p>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <a href="{{url('frequently-asked-questions')}}" class="cmn--btn">@lang('View All') <span class="round-effect">
                            <i class="fas fa-long-arrow-alt-right"></i>
                        </span></a>
                </div>
            </div>
        </div>
    </div>
</section>