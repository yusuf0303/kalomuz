<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        Service::create([
            'title' => "Qur’on tarjimasi va tafsiri",
            'desc'  => "Qur’onning har bir surasi tafsiri bilan birga.",
            'img'   => "images/backgroundpics/quran_translations.jpg",
            'url'   => "/tafsir",
        ]);
        Service::create([
            'title' => "Diniy ilm testi",
            'desc'  => "Qur’on bilimlaringizni sinovdan o‘tkazing.",
            'img'   => "images/backgroundpics/quran_quizzes.jpg",
            'url'   => "/quiz",
        ]);
        // Yana xizmatlar qo‘shishingiz mumkin...
    }
}
