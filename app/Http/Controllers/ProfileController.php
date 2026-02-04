<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        $user = Auth::user();
        $points = \Illuminate\Support\Facades\DB::table('contest_users')
            ->where('user_id', $user->id)
            ->value('points') ?? 0;
            
        return view('profile.show', compact('user', 'points'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'username' => [
                'nullable',
                'string',
                'min:3',
                'max:255',
                'unique:users,username,' . $user->id,
                'regex:/^[a-zA-Z0-9_]+$/'
            ],
            'phone' => 'nullable|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'username.regex' => 'Username faqat lotin harflari, raqamlar va pastki chiziqdan iborat bo\'lishi kerak.',
            'username.min' => 'Username kamida 3 ta belgidan iborat bo\'lishi kerak.',
            'username.unique' => 'Ushbu username band. Iltimos boshqasini tanlang.',
        ]);

        $user->name = $data['name'];
        $user->last_name = $data['last_name'];
        $user->username = $data['username'];
        $user->phone = $data['phone'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil muvaffaqiyatli yangilandi!');
    }
}
