<?php

namespace App\Http\Controllers;
// Added to support email sending.
use Mail;
use Illuminate\Http\Request;
use App\Models\Faq;


class ContactUsController extends Controller
{
    public function showContactUs() {
        return view('pages.contactUs', []);
    }

}