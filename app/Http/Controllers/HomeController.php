<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Types\Types;
use Illuminate\Support\Facades\Auth;
use stdClass;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $devices = Device::query()->where("user_id", "=", Auth::user()->getAuthIdentifier())->get();

        $deviceNamesMapUtility = [];
        foreach ($devices as $device)
            $deviceNamesMapUtility[$device->name] = new stdClass();

        return view('home')->with("devices", $devices)
            ->with("device_name", $deviceNamesMapUtility)
            ->with("deviceTypes", Types::DEVICE_TYPES());
    }
}
