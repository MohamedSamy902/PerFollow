<section class="client-section pt-50 pb-100">
    <div class="container">
        <div class="section-header text-center">
            <h6 class="section-header__subtitle">@lang(@$section->content->title)</h6>
            <h2 class="section-header__title">@lang(@$section->content->heading)</h2>
        </div>
        <div class="clients-wrapper">
            <div class="client-slider owl-theme owl-carousel">
                @if (is_array($section->sub_content))
                    @foreach ($section->sub_content as $item)
                        <div class="client-box">
                            <div class="client-box-img">
                                <img src="{{getPhoto($item->image)}}" alt="client">
                            </div>
                            <div class="client-box-content">
                                <h5 class="title">{{$item->name}}</h5>
                                <blockquote class="client-quote">
                                   @lang($item->quote)
                                </blockquote>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>