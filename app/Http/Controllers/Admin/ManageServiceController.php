<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use App\Models\Category;
use App\Models\Provider;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ManageServiceController extends Controller
{

    public function allServices()
    {
        $services = Service::when(request('service'), function ($q){
            return $q->where('title', 'LIKE', "%".request('service')."%");
        })
        ->when(request('category'), function ($q) {
            return $q->where('category_id', request('category'));
        })
        ->when(request('provider'), function ($q) {
            return $q->where('provider_id', request('provider'));
        })
        ->when(request('status'), function ($q) {
            return $q->where('status', request('status'));
        })->with(['provider','category'])->paginate(15);

        return view('admin.services.services', compact('services'));
    }

    public function serviceCategory()
    {
        $categories = Category::with(['services', 'services.provider'])->withCount('services')->paginate(16);
        return view('admin.services.list', compact('categories'));
    }

    public function services($slug)
    {
        $category = Category::where('slug',$slug)->firstOrFail();
        $services = Service::where('category_id', $category->id)
        ->when(request('service'), function ($q){
            return $q->where('title', 'LIKE', "%".request('service')."%");
        })
        ->when(request('provider'), function ($q) {
            return $q->where('provider_id', request('provider'));
        })
        ->when(request('status'), function ($q) {
            return $q->where('status', request('status'));
        })
        ->with(['provider','category'])->paginate(15);

        return view('admin.services.services', compact('services', 'category'));
    
    }
    

    public function create()
    {
        $categories = Category::where('status', 1)->get();
        $providers  = Provider::where('status', 1)->get();
        session()->forget('service_id');
        return view('admin.services.create_service', compact('categories', 'providers'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'title'         => 'required|unique:services',
            'category_id'   => 'required',
            'provider_id'   => 'required',
            'price'         => 'required|gt:0',
            'min_amount'    => 'required|gt:0',
            'max_amount'    => 'required|gte:min_amount',
            'type'          => 'required',
            'provider_id'   => 'required_if:type,1',
            'service_id'    => 'required_if:type,1',
            'description'   => 'required',
            'status'        => 'required',
        ]);

        if($request->provider_id && $request->service_id){
           try {
                $res = apiCall(Provider::findOrFail($request->provider_id), 'services');
                $index = array_search($request->service_id, array_column($res, 'service'));
                $final = $res[$index];
                $data['provider_price'] = $final['rate'];
           } catch (\Throwable $th) {
                return back()->with('error', 'Provider API not responding');
           }
        }
        Service::create($data);
        return back()->with('success', 'Service added successfully');
    }

    public function edit($id)
    {
        if(url()->previous() == url('admin/all-services')) session()->put('all',url('admin/all-services'));
        else session()->forget('all');
        $service    = Service::findOrFail($id);
        $categories = Category::where('status', 1)->get();
        $providers  = Provider::where('status', 1)->get();
        session()->put('service_id',$service->service_id);
        return view('admin.services.edit_service', compact('service', 'categories', 'providers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'title'         => 'required|unique:services,title,'.$request->id,
            'category_id'   => 'required',
            'provider_id'   => 'required',
            'price'         => 'required|gt:0',
            'min_amount'    => 'required|gt:0',
            'max_amount'    => 'required|gte:min_amount',
            'type'          => 'required',
            'provider_id'   => 'required_if:type,1',
            'service_id'    => 'required_if:type,1',
            'description'   => 'required',
            'status'        => 'required',
        ]);

        if($request->provider_id && $request->service_id){
           try {
                $res   = apiCall(Provider::findOrFail($request->provider_id), 'services');
                $index = array_search($request->service_id, array_column($res, 'service'));
                $final = $res[$index];
                $data['provider_price'] = $final['rate'];
           } catch (\Throwable $th) {
                return back()->with('error', 'Provider API not responding');
           }
        }
        Service::findOrFail($request->id)->update($data);
        return back()->with('success', 'Service updated successfully');
    }

    public function statusChange($id)
    {
        $service = Service::findOrFail($id);
        $service->status = $service->status == 1 ? 0 : 1;
        $service->update();
        return back()->with('success','Service status updated');
    }

    public function getService()
    {
        $provider = Provider::findOrFail(request('provider_id'));
        $res =  apiCall($provider, 'services');
        if(request('import')){
            return view('admin.services.import_list', compact('res'));
        }
        return view('admin.services.service_list', compact('res'));
    }

    public function importService()
    {
        $categories = Category::where('status', 1)->get();
        $providers  = Provider::where('status', 1)->get();
        return view('admin.services.import_service',compact('categories', 'providers'));
    }

    public function importServiceUpdate(Request $request)
    {
        $request->validate([
            'category_id'   => 'required',
            'provider_id'   => 'required',
            'price_inc'     => 'required|integer|gt:0',
            'service'       => 'required',
        ]);
        
        foreach ($request->service as $value) {
            $service = json_decode($value);
            Service::create([
                'title'         => $service->name,
                'category_id'   => $request->category_id,
                'provider_id'   => $request->provider_id,
                'price'         => (float)$service->rate + ((float)$service->rate * (float)$request->price_inc / 100),
                'min_amount'    => $service->min,
                'max_amount'    => $service->max,
                'type'          => 1,
                'service_id'    => $service->service,
                'description'   => $service->name,
                'provider_price'=> $service->rate,
                'status'        => 1,
            ]);
        }

        return back()->with('success', 'Services imported successfully');
    }

    public function multiAction(Request $request)
    {
        $request->validate(['status' => 'required|in:1,0','services'=>'required|array','services.*'=>'required|integer'],
         ['services.required'=>'Please select atleast one service']);
         
        Service::whereIn('id',$request->services)->update(['status' => $request->status]);
        return back()->with('success', 'Service status has been changed');
        
    }


}
