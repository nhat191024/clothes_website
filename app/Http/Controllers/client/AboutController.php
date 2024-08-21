<?php


namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index(){
        $About_us  = AboutUs::first();
        return view('client.about.about',compact('About_us'));
    }
}
