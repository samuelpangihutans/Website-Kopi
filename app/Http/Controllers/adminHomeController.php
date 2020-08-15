<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\post;

class adminHomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
         return view('adminHome');

    }

 
}
