<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SavedAyah;
use Illuminate\Support\Facades\Auth;

class SavedAyahController extends Controller
{
    public function index()
    {
        $savedAyahs = Auth::user()->savedAyahs()->orderBy('created_at', 'DESC')->get();
        return view('quran.saved_ayahs', compact('savedAyahs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'surah' => 'required|integer',
            'ayah' => 'required|integer',
            'ayah_image' => 'nullable|string',
            'text' => 'nullable|string',
            'sajda' => 'boolean',
            'audio' => 'nullable|string'
        ]);

        SavedAyah::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'surah' => $data['surah'],
                'ayah' => $data['ayah']
            ],
            $data
        );

        return response()->json(['status' => 'ok']);
    }

    public function destroy($id)
    {
        $ayah = SavedAyah::findOrFail($id);
        if ($ayah->user_id === Auth::id()) {
            $ayah->delete();
        }
        return response()->json(['status' => 'deleted']);
    }
}

