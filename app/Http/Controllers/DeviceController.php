<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Sensor;
use App\Types\Types;
use Faker\Core\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeviceController extends Controller
{

    public function addDevice(Request $request)
    {
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

    public function editDevice(Request $request)
    {
        $deviceUuid = $request->input("device_uuid");
        if ($deviceUuid) {
            $device = Device::query()->where('uuid', '=', $deviceUuid)->first();

            $relatedSensors = DB::table("sensor")->where("device_uuid", "=", $deviceUuid)->get();
            return view("layouts.device.edit")->with("device", $device)
                ->with("deviceTypes", Types::SENSOR_TYPES())
                ->with("relatedSensors", $relatedSensors);
        }

    }

    public function getAllDevices()
    {
        return Device::all();
    }

}
