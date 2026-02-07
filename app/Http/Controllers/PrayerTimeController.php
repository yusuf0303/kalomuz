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

    private $aladhanCities = [
        "Toshkent" => "Tashkent",
        "Andijon" => "Andijan",
        "Farg'ona" => "Fergana",
        "Namangan" => "Namangan",
        "Samarqand" => "Samarkand",
        "Buxoro" => "Bukhara",
        "Navoiy" => "Navoi",
        "Xorazm" => "Urgench",
        "Qashqadaryo" => "Qarshi",
        "Surxondaryo" => "Termiz",
        "Jizzax" => "Jizzakh",
        "Sirdaryo" => "Guliston",
        "Qoraqalpog'iston" => "Nukus"
    ];

    public function index(Request $request)
    {
        $region = $request->get('region', session('prayer_region', 'Toshkent'));
        $apiRegion = $this->regionMapping[$region] ?? 'Toshkent';

        // Kunlik vaqtlar - IslomAPI
        try {
            $dayResponse = Http::timeout(5)->get("{$this->apiUrl}/day?region={$apiRegion}");
            $dayData = $dayResponse->successful() && !($dayResponse->json()['success'] ?? true === false) 
                ? $dayResponse->json() 
                : $this->getAladhanData($region, 'day');
        } catch (\Exception $e) {
            $dayData = $this->getAladhanData($region, 'day');
        }

        // Haftalik vaqtlar - IslomAPI
        try {
            $weekResponse = Http::timeout(5)->get("{$this->apiUrl}/week?region={$apiRegion}");
            $weekData = $weekResponse->successful() ? $weekResponse->json() : $this->getAladhanData($region, 'week');
        } catch (\Exception $e) {
            $weekData = $this->getAladhanData($region, 'week') ?: [];
        }

        $regions = array_keys($this->regionMapping);

        return view('prayer.index', compact('dayData', 'weekData', 'region', 'regions'));
    }

    private function getAladhanData($region, $type = 'day')
    {
        $city = $this->aladhanCities[$region] ?? $region;
        $method = 3; // Muslim World League
        $school = 1; // Hanafi

        try {
            if ($type === 'day') {
                $response = Http::timeout(10)->get("http://api.aladhan.com/v1/timingsByCity", [
                    'city' => $city,
                    'country' => 'Uzbekistan',
                    'method' => $method,
                    'school' => $school
                ]);

                if ($response->successful()) {
                    $resData = $response->json();
                    if ($resData['code'] == 200) {
                        $timings = $resData['data']['timings'];
                        $dateInfo = $resData['data']['date'];
                        
                        $weekdayMap = [
                            "Monday" => "Dushanba",
                            "Tuesday" => "Seshanba",
                            "Wednesday" => "Chorshanba",
                            "Thursday" => "Payshanba",
                            "Friday" => "Juma",
                            "Saturday" => "Shanba",
                            "Sunday" => "Yakshanba"
                        ];

                        return [
                            "region" => $region,
                            "date" => $dateInfo['gregorian']['date'],
                            "weekday" => $weekdayMap[$dateInfo['gregorian']['weekday']['en']] ?? $dateInfo['gregorian']['weekday']['en'],
                            "times" => [
                                "tong_saharlik" => $timings['Fajr'],
                                "quyosh" => $timings['Sunrise'],
                                "peshin" => $timings['Dhuhr'],
                                "asr" => $timings['Asr'],
                                "shom_iftor" => $timings['Maghrib'],
                                "hufton" => $timings['Isha']
                            ]
                        ];
                    }
                }
            } else {
                // Weekly data fallback
                $response = Http::timeout(10)->get("http://api.aladhan.com/v1/calendarByCity", [
                    'city' => $city,
                    'country' => 'Uzbekistan',
                    'method' => $method,
                    'school' => $school,
                    'annual' => 'false',
                    'month' => date('m'),
                    'year' => date('Y')
                ]);

                if ($response->successful()) {
                    $resData = $response->json();
                    if ($resData['code'] == 200) {
                        $weekData = [];
                        $today = date('d');
                        $count = 0;
                        
                        foreach ($resData['data'] as $day) {
                            if ($day['date']['gregorian']['day'] >= $today && $count < 7) {
                                $timings = $day['timings'];
                                $dateInfo = $day['date'];
                                
                                $weekdayMap = [
                                    "Monday" => "Dushanba",
                                    "Tuesday" => "Seshanba",
                                    "Wednesday" => "Chorshanba",
                                    "Thursday" => "Payshanba",
                                    "Friday" => "Juma",
                                    "Saturday" => "Shanba",
                                    "Sunday" => "Yakshanba"
                                ];

                                $weekData[] = [
                                    "date" => $dateInfo['gregorian']['date'],
                                    "weekday" => $weekdayMap[$dateInfo['gregorian']['weekday']['en']] ?? $dateInfo['gregorian']['weekday']['en'],
                                    "times" => [
                                        "tong_saharlik" => $timings['Fajr'],
                                        "quyosh" => $timings['Sunrise'],
                                        "peshin" => $timings['Dhuhr'],
                                        "asr" => $timings['Asr'],
                                        "shom_iftor" => $timings['Maghrib'],
                                        "hufton" => $timings['Isha']
                                    ]
                                ];
                                $count++;
                            }
                        }
                        return $weekData;
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error("Aladhan API error: " . $e->getMessage());
        }

        return null;
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
