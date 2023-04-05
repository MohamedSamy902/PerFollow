<section class="how-section pt-50 pb-50">
    <div class="container">
        <div class="section-header text-center">
            <h6 class="section-header__subtitle">@lang(@$section->content->title)</h6>
            <h2 class="section-header__title">@lang(@$section->content->heading)</h2>
            <p>
                @lang(@$section->content->sub_heading)
            </p>
        </div>
        <div class="how--wrapper">
            @if (is_array($section->sub_content))
                @foreach ($section->sub_content as $item)
                    <div class="how__item {{$loop->even ? 'active' : '' }}">
                        <div class="how__item-icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="how__item-cont">
                            <h5 class="title">{{__($item->title)}}</h5>
                            <p>
                                @lang($item->details)
                            </p>
                        </div>
                    </div>
                @endforeach
            @endif
           
        </div>
    </div>
</section>