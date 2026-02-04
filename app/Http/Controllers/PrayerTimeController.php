<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PrayerTimeController extends Controller
{
    private $apiUrl = "https://islomapi.uz/api/present";

    private $regionMapping = [
        "Toshkent" => "Toshkent",
        "Andijon" => "Andijon",
        "Farg'ona" => "Farg'ona",
        "Namangan" => "Namangan",
        "Samarqand" => "Samarqand",
        "Buxoro" => "Buxoro",
        "Navoiy" => "Nurota",
        "Xorazm" => "Urganch",
        "Qashqadaryo" => "Qarshi",
        "Surxondaryo" => "Termiz",
        "Jizzax" => "Jizzax",
        "Sirdaryo" => "Guliston",
        "Qoraqalpog'iston" => "Nukus"
    ];

    public function index(Request $request)
    {
        $region = $request->get('region', session('prayer_region', 'Toshkent'));
        $apiRegion = $this->regionMapping[$region] ?? 'Toshkent';

        // Kunlik vaqtlar
        $dayResponse = Http::get("{$this->apiUrl}/day?region={$apiRegion}");
        $dayData = $dayResponse->successful() ? $dayResponse->json() : null;

        // Haftalik vaqtlar
        $weekResponse = Http::get("{$this->apiUrl}/week?region={$apiRegion}");
        $weekData = $weekResponse->successful() ? $weekResponse->json() : [];

        $regions = array_keys($this->regionMapping);

        return view('prayer.index', compact('dayData', 'weekData', 'region', 'regions'));
    }

    public function setRegion(Request $request)
    {
        $region = $request->input('region');
        if (isset($this->regionMapping[$region])) {
            session(['prayer_region' => $region]);
        }
        return redirect()->back();
    }
}
