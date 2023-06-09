@extends('layouts.admin')

@section('title')
   @lang(ucfirst($section->name).' Section')
@endsection

@section('breadcrumb')
 <section class="section">
    <div class="section-header d-flex justify-content-between">
        <h1>@lang(ucfirst($section->name).' Section')</h1>
        <a href="{{route('admin.frontend.index')}}" class="btn btn-primary"><i class="fa fa-backward"></i> @langg('Back')</a>
    </div>
</section>
@endsection

@section('content')
    <div class="row">
        @if ($section->content)
        <div class="col-md-12">
           <div class="card">
               <div class="card-header">
                    <h6>@lang(ucfirst($section->name).' Content')</h6>
               </div>
               <div class="card-body">
                    <form action="{{route('admin.frontend.content.update',$section->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                           @if ($section->content->image)
                           <div class="form-group col-md-12">
                                <label for="">@langg('Background Image')</label>
                                <div class="gallery gallery-fw"  data-item-height="450">
                                    <img class="gallery-item imageShow" data-image="{{getPhoto(@$section->content->image)}}">
                                </div>
                                <div class="custom-file">
                                    <input type="file" name="image"  class="custom-file-input imageUpload mb-2" id="customFile">
                                    <code class="text-danger">@langg('Image size : 1030 x 930 px')</code>
                                    <input type="hidden" name="image_size" value="1030x930">
                                    <label class="custom-file-label" for="customFile">@langg('Choose file')</label>
                                </div>
                            </div>
                           @endif
                            <div class="form-group col-md-6">
                                <label for="">@langg('Title')</label>
                                <input type="text" name="title" class="form-control" placeholder="@langg('Banner Title')" value="{{@$section->content->title}}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">@langg('Heading')</label>
                                <input type="text" name="heading" class="form-control" placeholder="@langg('Banner Heading')" value="{{@$section->content->heading}}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">@langg('Sub Heading')</label>
                                <input type="text" name="sub_heading" class="form-control" placeholder="@langg('Banner Sub Heading')" value="{{@$section->content->sub_heading}}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">@langg('Button Name')</label>
                                <input type="text" name="button_1_name" class="form-control" placeholder="@langg('Button Name')" value="{{@$section->content->button_1_name}}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="">@langg('Button URL')</label>
                                <input type="text" name="button_1_url" class="form-control" placeholder="@langg('Button URL')" value="{{@$section->content->button_1_url}}" required>
                            </div>
                           
                            
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-block btn-lg">@langg('Submit')</button>
                            </div>
                        </div>
                    </form>
               </div>
           </div>
        </div>
        @endif
      
    </div>
@endsection

@push('script')
    <script>
        'use strict'
        function imageShow(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(input).parents('.form-group').find('.imageShow').attr('src',e.target.result)
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $(".imageUpload").on('change', function () {
            imageShow(this);
        });
    </script>
@endpush