<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Currency;

class ManageCountryController extends Controller
{
    public function index()
    {
        $search = request('search');
        $countries = Country::when($search,function($q) use($search){$q->where('name','like',"%$search%");})->paginate(16);
        $countryJson = @json_decode(file_get_contents(resource_path('views/admin/partials/countries.json')));
        $currencies = Currency::get();
        return view('admin.country.index',compact('countries','countryJson','currencies','search'));
    }

    

    public function update(Request $request)
    {
        $request->validate([
            'currency'       => 'required|integer'
        ]);

        $country = Country::findOrFail($request->id);
        $country->currency_id = $request->currency;
        $country->update();
        return back()->with('success','Country has been updated');
    }

    public function updateStatus($id)
    {
        $country = Country::findOrFail($id);
        $country->status = $country->status == 1 ? 0 : 1;
        $country->update();
        return back()->with('success','Country status updated');
    }

       
}
