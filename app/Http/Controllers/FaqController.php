<?php

namespace App\Http\Controllers;

use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::published()
            ->orderBy('category')
            ->orderBy('order')
            ->get()
            ->groupBy('category');

        return view('pages.faq', compact('faqs'));
    }
}