<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuranQuizController extends Controller
{
    private $apiUrl = "https://api.alquran.cloud/v1";

    public function show()
    {
        return view('quran.quiz_setup');
    }

    public function generate(Request $request)
    {
        $juzs = $request->input('juzs', [1]);
        $count = $request->input('count', 10);
        $timeLimit = $request->input('time', 30);

        try {
            $allAyahs = [];
            foreach ($juzs as $juz) {
                // Arabcha + Audio
                $res = Http::get("{$this->apiUrl}/juz/{$juz}/ar.alafasy");
                if ($res->successful()) {
                    $ayahs = $res->json()['data']['ayahs'];
                    
                    // Tarjimalar (O'zbekcha)
                    $transRes = Http::get("{$this->apiUrl}/juz/{$juz}/uz.sodik");
                    $transAyahs = $transRes->json()['data']['ayahs'];

                    foreach ($ayahs as $index => $ayah) {
                        $ayah['translation'] = $transAyahs[$index]['text'];
                        $allAyahs[] = $ayah;
                    }
                }
            }

            if (count($allAyahs) < $count) {
                return response()->json(['error' => 'Tanlangan juzlarda yetarli oyatlar yo\'q.'], 400);
            }

            $selectedAyahs = collect($allAyahs)->random($count);
            $questions = [];

            // Surah names list for wrong options
            $surahsRes = Http::get("{$this->apiUrl}/surah");
            $allSurahs = $surahsRes->json()['data'];

            foreach ($selectedAyahs as $ayah) {
                $correctSurah = $ayah['surah']['englishName'];
                $options = [$correctSurah];

                while (count($options) < 4) {
                    $randomSurah = collect($allSurahs)->random()['englishName'];
                    if (!in_array($randomSurah, $options)) {
                        $options[] = $randomSurah;
                    }
                }

                shuffle($options);

                $questions[] = [
                    'audio' => $ayah['audio'],
                    'image' => "https://cdn.islamic.network/quran/images/high-resolution/{$ayah['surah']['number']}_{$ayah['numberInSurah']}.png",
                    'arabic' => $ayah['text'],
                    'translation' => $ayah['translation'],
                    'options' => $options,
                    'correct' => array_search($correctSurah, $options),
                    'surah' => $correctSurah,
                    'ayah_num' => $ayah['numberInSurah']
                ];
            }

            return view('quran.quiz_play', compact('questions', 'timeLimit'));

        } catch (\Exception $e) {
            Log::error("Quiz Generation Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Xatolik yuz berdi. Iltimos qaytadan urinib ko\'ring.');
        }
    }

    public function recordScore(Request $request)
    {
        $user = Auth::user();
        if (!$user) return response()->json(['status' => 'guest']);

        $score = $request->input('score');
        
        // Update contest points
        DB::table('contest_users')
            ->where('user_id', $user->id)
            ->increment('points', $score);

        // Record history
        DB::table('quiz_history')->insert([
            'user_id' => $user->id,
            'score' => $score,
            'quiz_type' => 'custom',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json(['status' => 'success', 'points_added' => $score]);
    }
}
