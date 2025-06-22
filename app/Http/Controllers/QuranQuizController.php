<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class QuranQuizController extends Controller
{
    public function show()
    {
        return view('quran_quiz');
    }
}
