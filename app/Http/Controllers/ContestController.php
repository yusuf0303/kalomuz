<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ContestController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $contestUser = null;
        if ($user) {
            $contestUser = DB::table('contest_users')->where('user_id', $user->id)->first();
        }

        $leaderboard = DB::table('contest_users')
            ->join('users', 'contest_users.user_id', '=', 'users.id')
            ->select('users.name', 'contest_users.points')
            ->orderBy('points', 'DESC')
            ->limit(10)
            ->get();

        return view('contest.index', compact('contestUser', 'leaderboard'));
    }

    public function join()
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');

        DB::table('contest_users')->updateOrInsert(
            ['user_id' => $user->id],
            ['points' => 10, 'has_joined_bonus' => true, 'created_at' => now(), 'updated_at' => now()]
        );

        return redirect()->back()->with('success', 'Konkursga muvaffaqiyatli qo\'shildingiz!');
    }
}
