<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QuranController extends Controller
{
    private $apiUrl = "https://api.alquran.cloud/v1";

    public function index()
    {
        // Surahlar ro'yxatini olish
        $response = Http::get("{$this->apiUrl}/surah");
        $surahs = $response->json()['data'];

        return view('quran.index', compact('surahs'));
    }

    public function show($id)
    {
        // Sura ma'lumotlarini olish (Arabcha + Audio)
        $surahResponse = Http::get("{$this->apiUrl}/surah/{$id}/ar.alafasy");
        $surah = $surahResponse->json()['data'];

        // O'zbekcha tarjimani olish
        $translationResponse = Http::get("{$this->apiUrl}/surah/{$id}/uz.sodik");
        $translation = $translationResponse->json()['data'];

        return view('quran.show', compact('surah', 'translation'));
    }

    public function sajda()
    {
        // 1. Sajda oyatlarini olish (Arabic text)
        $response = Http::get("{$this->apiUrl}/sajda/quran-uthmani");
        $ayahs = $response->json()['data']['ayahs'];

        // 2. O'zbekcha tarjimani olish (all ayahs from Sodik edition)
        $translationResponse = Http::get("{$this->apiUrl}/sajda/uz.sodik");
        if ($translationResponse->successful()) {
            $translations = $translationResponse->json()['data']['ayahs'];
            
            // Map translations to ayahs
            foreach ($ayahs as $index => &$ayah) {
                $ayah['translation'] = $translations[$index]['text'] ?? 'Tarjima topilmadi.';
                // Set audio URL (standard 128kbps Afasy)
                $ayah['audio'] = "https://cdn.islamic.network/quran/audio/128/ar.alafasy/{$ayah['number']}.mp3";
            }
        }

        return view('quran.sajda', compact('ayahs'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        if (empty($query)) {
            return response()->json([]);
        }

        // Oddiyroq qidiruv logikasi (Sura nomi bo'yicha)
        $response = Http::get("{$this->apiUrl}/surah");
        $surahs = $response->json()['data'];

        $filtered = array_filter($surahs, function($surah) use ($query) {
            return str_contains(strtolower($surah['englishName']), strtolower($query)) || 
                   str_contains(strtolower($surah['name']), strtolower($query));
        });

        return response()->json(array_values($filtered));
    }
}
