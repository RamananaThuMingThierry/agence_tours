<?php

namespace App\Http\Controllers\FRONT;

use App\Models\Slide;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontofficeController extends Controller
{
    public function index(){
        $slides = Slide::orderBy('order')->get();
        return view('frontoffice.index', compact('slides'));
    }
}
