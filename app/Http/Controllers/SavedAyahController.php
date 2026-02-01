<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SavedAyah;
use Illuminate\Support\Facades\Auth;

class SavedAyahController extends Controller
{
    public function index()
    {
        return Auth::user()->savedAyahs()->get();
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

        $data['user_id'] = Auth::id();

        // Bitta oyat faqat bir marta saqlansin
        $exists = SavedAyah::where('user_id', $data['user_id'])
            ->where('surah', $data['surah'])
            ->where('ayah', $data['ayah'])
            ->first();

        if (!$exists) {
            SavedAyah::create($data);
        }

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

