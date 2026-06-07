<?php
namespace App\Http\Controllers\Web\Frontend;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return redirect()->route('login');
    }
    //emailTempalete
    public function emailTempalete()
    {
        return view('emails.template');
    }
}
