@extends('layouts.frontend')

@section('title')
    @langg('Blogs')
@endsection

@section('content')
    <!-- Blog -->
    <section class="blog-section pt-100 pb-100">
        <div class="container">
            <div class="row justify-content-center gy-4">
                @forelse ($blogs as $item)
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
                @empty
                <div class="col-lg-4 col-md-6 col-sm-10">
                    <div class="blog__item">
                        <div class="blog__item-content">
                            <h5 class="blog__item-content-title text-center">
                                @langg('No Blog Found!')
                            </h5>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
            @if ($blogs->hasPages())
            <ul class="pagination">
                {{$blogs->links()}}
            </ul>
            @endif
        </div>
    </section>
    <!-- Blog -->
@endsection