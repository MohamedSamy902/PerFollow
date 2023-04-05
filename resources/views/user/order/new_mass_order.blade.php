@extends('layouts.user')
@section('title')
    @langg('Mass Order')
@endsection

@section('content')
<section class="user-panel pt-100 pb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="profile--card">
                    <form action="" method="POST">
                        @csrf
                        <div class="row gy-3">
                            <div class="col-lg-2 col-md-3">
                                <label for="plan" class="form-label">@langg('Service ID') <sup class="text-danger">*</sup></label>
                                <input name="order[0][id]" class="form-control form--control bg--body" placeholder="e.g : 65" required>
                            </div>
                            <div class="col-lg-7 col-md-5">
                                <label for="plan" class="form-label">@langg('Link') <sup class="text-danger">*</sup></label>
                                <input name="order[0][link]" class="form-control form--control bg--body" placeholder="https://yourlink.com" required>
                            </div>
                            <div class="col-lg-2 col-md-3 col-9">
                                <label for="plan" class="form-label">@langg('Quantity') <sup class="text-danger">*</sup></label>
                                <input name="order[0][qty]" class="form-control form--control bg--body" placeholder="e.g : 100" required>
                            </div>
                            <div class="col-3 col-md-1">
                                <label class="form-label d-block">&nbsp;</label>
                                <button type="button" class="btn btn-success add-more">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="append"></div>
                        <div class="col-12 mt-4">
                            <button type="submit" class="cmn--btn w-100">@langg('Place Order') <i class="fas fa-long-arrow-alt-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@push('script')

<script>
    'use strict';
    var i = 1
    $('.add-more').on('click', function() {
        var html = `<div class="row gy-3 mt-4 mt-md-2">
                        <div class="col-lg-2 col-md-3">
                            <input name="order[${i}][id]" class="form-control form--control bg--body" placeholder="e.g : 65" required>
                        </div>
                        <div class="col-lg-7 col-md-5">
                            <input name="order[${i}][link]" class="form-control form--control bg--body" placeholder="https://yourlink.com" required>
                        </div>
                        <div class="col-lg-2 col-md-3 col-9">
                            <input name="order[${i}][qty]" class="form-control form--control bg--body" placeholder="e.g : 100" required>
                        </div>
                        <div class="col-3 col-md-1">
                            <button type="button" class="btn btn-danger remove">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>`;
        $('.append').append(html);
        i++;
    })

    $(document).on('click', '.remove', function() {
        $(this).closest('.row').remove();
    })
</script>
@endpush