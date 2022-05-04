<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{

    public function addDevice(Request $request) {
        
    }

    public function getAllDevices() {
        return Device::all();
    }

}
