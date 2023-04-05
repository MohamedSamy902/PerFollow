<!-- Blog -->
@php
    $blogs = App\Models\Blog::where('status',1)->whereHas('category',function($q){
        $q->where('status',1);
    })->latest()->inRandomOrder()->take(3)->get();
@endphp

<section class="blog-section pt-50 pb-100">
    <div class="container">
        <div class="section-header text-center">
            <h6 class="section-header__subtitle">@lang(@$section->content->title)</h6>
            <h2 class="section-header__title">@lang(@$section->content->heading)</h2>
            <p>
                @lang(@$section->content->sub_heading)
            </p>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach ($blogs as $item)
            <div class="col-lg-4 col-md-6">
                <div class="post-item">
                    <div class="post-item__img">
                        <a href="{{route('blog.details',[$item->id,$item->slug])}}">
                            <img src="{{getPhoto($item->photo)}}" alt="blog">
                        </a>
                        <span class="date">{{dateFormat($item->created_at,'d M')}}</span>
                    </div>
                    <div class="post-item__content">
                        <h5 class="title"><a href="{{route('blog.details',[$item->id,$item->slug])}}">{{Str::limit($item->title,30)}}</a></h5>
                        <a href="{{route('blog.details',[$item->id,$item->slug])}}" class="read-more">@lang('Read More')</a>
                    </div>
                </div>
            </div>
            @endforeach
            
        </div>
    </div>
</section>