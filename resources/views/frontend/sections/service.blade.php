<section class="feature-section pt-50 pb-50">
    <div class="container">
        <div class="section-header text-center">
            <h6 class="section-header__subtitle">@lang(@$section->content->title)</h6>
            <h2 class="section-header__title">@lang(@$section->content->heading)</h2>
            <p>
                @lang(@$section->content->sub_heading)
            </p>
        </div>
        <div class="row g-3 g-md-4 g-lg-3 g-xl-4">
            @if (is_array($section->sub_content))
                @foreach ($section->sub_content as $item)
                    <div class="col-lg-3 col-sm-6">
                        <div class="feature-item">
                            <div class="feature-item__icon">
                                <i class="{{$item->icon}}"></i>
                            </div>
                            <div class="feature-item__cont">
                                <h5 class="feature-item__cont-title">
                                    <a href="">{{$item->title}}</a>
                                </h5>
                                <p>
                                    {{$item->details}}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>