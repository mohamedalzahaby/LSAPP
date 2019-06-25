<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        $title = 'index';
        return view('pages.index')->with('title' , $title);
    }
    public function about()
    {
        $title = 'about Us';
        return view('pages.about')->with('title' , $title);
    }
    public function services()
    {
        $data = array(
            'title' => 'services' ,
             'services' => ['programming' , 'web Design' , 'SEO']
            );
        return view('pages.services')->with($data);
    }
}
