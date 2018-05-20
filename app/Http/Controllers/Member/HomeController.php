<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Service\Member\HomeService;

class HomeController extends Controller
{
    private $homeService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('member.home');
    }
}
