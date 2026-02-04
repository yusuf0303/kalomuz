<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MosqueController extends Controller
{
    private $apiUrl = "https://api.masjid.uz/api/v1";

    public function index(Request $request)
    {
        $provinceId = $request->get('province_id');
        $districtId = $request->get('district_id');

        $provinces = Http::get("{$this->apiUrl}/provinces")->json();
        $districts = $provinceId ? Http::get("{$this->apiUrl}/provinces/{$provinceId}/districts")->json() : [];
        $mosques = $districtId ? Http::get("{$this->apiUrl}/districts/{$districtId}/mosques")->json() : [];

        return view('mosques.index', compact('provinces', 'districts', 'mosques', 'provinceId', 'districtId'));
    }

    public function show($id)
    {
        // api.masjid.uz doesn't seem to have a single mosque detail endpoint that's obvious 
        // but we can pass coords to the view for the map.
        return response()->json(['status' => 'success']);
    }
}
