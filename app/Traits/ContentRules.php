<?php

namespace App\Traits;

trait ContentRules {
   
    public $commonRules = [
        'title'              => 'required',
        'heading'            => 'required',
        'sub_heading'        => 'required'
    ];

    public function banner()
    {
        return [
            'title'         => 'required',
            'heading'       => 'required',
            'sub_heading'   => 'required',
            'button_1_name' => 'required',
            'button_1_url'  => 'required',
            'image'         => 'image|mimes:jpg,jpeg,png|max:2048',
            'image_size'    => 'required_with:image'
        ];
    }

    public function about()
    {
        return [
            'title'              => 'required',
            'heading'            => 'required',
            'short_details'      => 'required',
            'button_url'         => 'required',
            'button_name'        => 'required',
            'image'              => 'image|mimes:jpg,jpeg,png|max:2048',
            'image_size'         => 'required_with:image'
        ];
    }

    public function about_subcontent()
    {
        return [
            'title'              => 'required',
            'count'              => 'required',
            'image'              => 'image|mimes:jpg,jpeg,png|max:2048',
            'image_size'         => 'required_with:image'
        ];
    }

    public function service()
    {
        return $this->commonRules;
    }
    public function service_subcontent()
    {
        return [
            'icon'               => 'required',
            'title'              => 'required',
            'details'            => 'required'
        ];
    }

    public function acknowledge()
    {
        return [
            'title'              => 'required',
            'heading'            => 'required',
            'button_url'         => 'required',
            'button_name'        => 'required',
            'short_details'      => 'required'
        ];
    }

    public function how()
    {
        return [
            'title'              => 'required',
            'heading'            => 'required',
            'sub_heading'        => 'required',
            'image'              => 'image|mimes:jpg,jpeg,png|max:2048',
            'image_size'         => 'required_with:image'
        ];
    }

    public function how_subcontent()
    {
        return [
            'icon'               => 'required',
            'title'              => 'required',
            'details'            => 'required'
        ];
    }
    public function counter()
    {
        return [
            'title'              => 'required',
            'heading'            => 'required',
            'sub_heading'        => 'required',
            'button_name'        => 'required',
            'button_url'         => 'required',
        ];
    }

    public function counter_subcontent()
    {
        return [
            'icon'               => 'required',
            'title'              => 'required',
            'counter'            => 'required'
        ];
    }

    public function feature()
    {
         return $this->commonRules;
    }
    public function feature_subcontent()
    {
        return [
            'image'              => 'image|mimes:jpg,jpeg,png,PNG|max:2048',
            'image_size'         => 'required_with:image',
            'title'              => 'required',
            'details'            => 'required'
        ];
    }

    public function faq()
    {
       return [
            'title'         => 'required',
            'heading'       => 'required',
            'sub_heading'   => 'required',
            'image'         => 'image|mimes:jpg,jpeg,png|max:2048',
            'image_size'    => 'required_with:image'
        ];
    }

    public function faq_subcontent()
    {
        return [
            'question'           => 'required',
            'answer'             => 'required'
        ];
    }

    public function testimonial()
    {
        return [
             'title'              => 'required',
             'heading'            => 'required',
        ];
    }

    public function testimonial_subcontent()
    {
        return [
            'image'              => 'image|mimes:jpg,jpeg,png,PNG|max:2048',
            'image_size'         => 'required_with:image',
            'name'               => 'required',
            'quote'              => 'required'
        ];
    }

    public function blog()
    {
         return $this->commonRules;
    }

    public function sponsors()
    {
        return $this->commonRules;
    }

    public function sponsors_subcontent()
    {
        return [
            'image'              => 'image|mimes:jpg,jpeg,png,PNG|max:2048',
            'image_size'         => 'required_with:image'
        ];
    }
    public function social_subcontent()
    {
        return [
            'icon'               => 'required',
            'url'                => 'required',
        ];
    }
    public function policies_subcontent()
    {
        return [
            'lang'               => 'required',
            'title'              => 'required',
            'description'        => 'required',
        ];
    }

    public function contact()
    {
        return [
            'title'              => 'required',
            'heading'            => 'required',
            'sub_heading'        => 'required',
            'phone'              => 'required',
            'email'              => 'required|email',
            'address'            => 'required'
       ];
    }

}
