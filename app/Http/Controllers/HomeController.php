<?php

namespace App\Http\Controllers;

use App\City;
use App\Courier;
use App\Province;
use Illuminate\Http\Request;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $province = $this->getProvince();
        $courier = $this->getCourier();
        return view('home', compact('province', 'courier'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $ongkir = RajaOngkir::ongkosKirim([
            'origin' => $request->origin_city,
            'destination' => $request->destination_city,
            'weight' => 1300,
            'courier' => $request->courier[0],
        ])->get();
        dd($ongkir);
    }


    public function getProvince()
    {
        return Province::pluck('title', 'code');
    }

    public function getCourier()
    {
        return Courier::all();
    }

    public function getCity($id)
    {
        return City::where('code', $id)->first();
    }

    public function getCities($provinceId)
    {
        $cities = City::where('province_code', $provinceId)->pluck('title', 'code');
        return json_encode($cities);
    }

    public function searchCities(Request $request)
    {
        $search = trim($request->search);

        if (empty($search)) {
            $cities = City::orderBy('title', 'asc')
                ->select('id', 'title')
                ->limit(5)->get();
        } else {
            $cities = City::orderBy('title', 'asc')
                ->where('title', 'like', '%' . $search . '%')
                ->select('id', 'title')
                ->limit(5)->get();
        }

        $response  = [];

        foreach ($cities as $city) {
            $response[] = ['id' => $city->id, 'text' => $city->title];
        }

        return json_encode($response);
    }
}
