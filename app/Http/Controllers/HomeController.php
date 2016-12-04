<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tweet;

class HomeController extends Controller
{
    private $hasTweets = false;
    private $tweets = false;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        $this->tweets = Tweet::get();
        $this->hasTweets = ($this->tweets->isEmpty()) ? false : true;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home',['hasTweets'=>$this->hasTweets,'tweets'=>$this->tweets]);
    }
}
