<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        $title = 'Welcome to my PHP Framework (!)';
        //return view('pages.index', compact('title'));
        return view('pages.index')->with('title', $title);
    }

    public function about(){
        $title = 'About US';
        return view('pages.about')->with('title', $title);
    }

    public function services(){
       
        $data = array(
            'title' => 'Servicess',
            'services' => ['Web Design','Blockchain Analyst','Data Science', 'Cybersecurity Analyst']
        );
        return view('pages.services')->with($data);
    }
    
}
