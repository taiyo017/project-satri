<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Career;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function show($slug)
    {
        $career = Career::where('slug', $slug)->where('is_open', true)->firstOrFail();

        return view('frontend.careers.show', compact('career'));
    }
}
