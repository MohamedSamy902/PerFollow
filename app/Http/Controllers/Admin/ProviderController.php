<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProviderController extends Controller
{
    public function providers()
    {
        $providers = Provider::latest()->get();
        return view('admin.provider.list',compact('providers'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:providers',
            'api_url' => 'required|url',
            'api_key' => 'required',
            'status' => 'required',
        ]);
        Provider::create($data);
        return back()->with('success','Provider added successfully');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:providers,name,'.$request->id,
            'api_url' => 'required|url',
            'api_key' => 'required',
            'status' => 'required',
        ]);
        Provider::findOrFail($request->id)->update($data);
        return back()->with('success','Provider updated successfully');
    }



    public function checkBalance(Request $request)
    {
        $response = Http::get($request->url, [
            'key'     =>  $request->key ,
            'action'  => $request->action,
        ])->json();
        
        return response()->json($response);
    }


}
