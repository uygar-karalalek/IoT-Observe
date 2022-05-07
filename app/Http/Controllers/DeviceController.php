<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Faker\Core\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{

    public function addDevice(Request $request) {
        $devName = $request->input("deviceName");
        $type = $request->input("deviceType");
        $device = new Device();
        $device->uuid = (new Uuid())->uuid3();
        $device->name = $devName;
        $device->type = $type;
        $device->setCreatedAt(now());
        $device->setUpdatedAt(now());
        $device->user_id = Auth::user()->id;
        $device->save();

        return redirect("/");
    }

    public function editDevice(Request $request) {
        $deviceUuid = $request->input("device_uuid");
        if ($deviceUuid) {
            return view("layouts.device.edit")->with("deviceUuid", $deviceUuid);
        }
    }

    public function getAllDevices() {
        return Device::all();
    }

}
