<?php

namespace App\Http\Controllers\FRONT;

use App\Models\Tour;
use App\Models\Slide;
use App\Models\Gallery;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontofficeController extends Controller
{
    public function index(){
        $slides = Slide::orderBy('order')->get();
        $galleries = Gallery::where('status', 'publish')->take(9)->get();
        $tours = Tour::with('images')->latest()->take(3)->get();
        $testimonials = Testimonial::where('status', 'publish')
            ->latest()
            ->take(3)
            ->get();
        return view('frontoffice.index', compact('slides', 'galleries','tours', 'testimonials'));
    }

    public function testimonials(){
        $testimonials = Testimonial::where('status', 'publish')->get();
        return view('frontoffice.testimonials.all', compact('testimonials'));
    }

    public function tours(){
        $tours = Tour::where('status', 'active')->get();
        return view('frontoffice.tours.all', compact('tours'));
    }
}
