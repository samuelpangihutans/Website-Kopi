<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\post;

class PagesController extends Controller
{
    public function index(){
        $posts= post::orderBy('name','desc')->paginate(6);
        return view('pages.index')->with('posts',$posts);
    }
   
}
