<?php

namespace App\Http\Controllers;
// Added to support email sending.
use Mail;
use Illuminate\Http\Request;
use App\Models\Faq;


class FaqController extends Controller
{
    public function showFaqs() {
        $allFaqs = Faq::all();

        return view('pages.faqs', ['allFAQs' => $allFaqs]);
    }

}