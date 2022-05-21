<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class IndexController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $devices = Device::query()->where("user_id", "=", Auth::user()->getAuthIdentifier())->get();

        return view('home')
            ->with("devices", $devices);
    }

}
