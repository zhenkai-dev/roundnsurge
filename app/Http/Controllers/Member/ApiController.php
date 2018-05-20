<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    /**
     * @return Authenticatable|null
     */
    public function currentUser(): ?Authenticatable
    {
        $user = Auth::user();
        return $user;
    }

    /**
     * @return \Illuminate\Config\Repository|mixed
     */
    public function setting()
    {
        $setting = config('setting');
        return $setting;
    }
}
