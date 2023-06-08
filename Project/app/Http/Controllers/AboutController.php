<?php

namespace App\Http\Controllers;
// Added to support email sending.
use Mail;
use Illuminate\Http\Request;
use App\Models\Faq;


class AboutController extends Controller
{
    public function showAbout() {
        return view('pages.about', []);
    }

}