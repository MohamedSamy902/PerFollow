<section class="counter-section pt-50 pb-50">
    <div class="container">
        <div class="inner-container bg--title">
            <div class="vector-layer-one"></div>
            <div class="vector-layer-two"></div>
            <div class="vector-layer-three"></div>
            <div class="vector-layer-four"></div>
            <div class="vector-layer-five"></div>
            <div class="vector-layer-six"></div>
            <!-- Fact Counter -->
            <div class="fact-counter">
                <div class="row">
                    @if (is_array($section->sub_content))
                        @foreach ($section->sub_content as $item)
                        <div class="counter-item mx-auto col-lg-3 col-md-6 col-sm-12">
                            <div class="inner">
                                <div class="content">
                                    <div class="icon">
                                        <i class="{{$item->icon}}"></i>
                                    </div>
                                    <div class="count-outer count-box counted">
                                        <span class="count-text">{{$item->counter}}</span>
                                    </div>
                                    <h5>{{$item->title}}</h5>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                  

                </div>
            </div>

        </div>
    </div>
</section>