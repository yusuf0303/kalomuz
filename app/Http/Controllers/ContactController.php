<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:128',
            'email' => 'required|email|max:255',
            'phone' => 'required|max:32',
            'message' => 'required|max:1500',
            'agree' => 'accepted'
        ]);
        // Key rename
        $data['user_message'] = $data['message'];
        unset($data['message']);

        Mail::send('emails.contact', $data, function($message) use ($data) {
            $message->to('kalomuz.info@gmail.com')
                ->subject('Yangi xabar: KalomUz kontakt formasi')
                ->from('kalomuz.info@gmail.com', $data['name'])
                ->replyTo($data['email'], $data['name']);
        });

        return back()->with('success', 'Xabaringiz yuborildi! Tez orada javob beramiz.');
    }

}
