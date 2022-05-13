<?php

namespace App\Http\Controllers;

use App\FormCycle\DeviceSensorEditForm;
use App\FormCycle\DeviceSensorEditFormCycle;
use App\Models\Device;
use App\Types\Types;
use Faker\Core\Uuid;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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
        $requestType = $request->input("request_type");
        if ($deviceUuid) {
            if($requestType == "goToAddSensorPage") {
                return $this->goToAddSensorPage($deviceUuid, $request);
            }
            else if ($requestType == "saveSensor") {
                $deviceSensorEditFormCycle = $this->getDeviceSensorEditFormCycleSessionObject($request);
                $deviceSensorEditFormCycle->setEditingActive(false);
                return "Ciao";
            }
        }

        return view("layouts.errors.cannot_edit");
    }

    public function getAllDevices()
    {
        return Device::all();
    }

    /**
     * @param mixed $deviceUuid
     * @param Request $request
     * @return Application|Factory|View
     */
    private function goToAddSensorPage(mixed $deviceUuid, Request $request): Application|Factory|View
    {
        $editing = boolval($request->input("editing"));

        $deviceSensorEditFormCycle = $this->getDeviceSensorEditFormCycleSessionObject($request);

        if (!$deviceSensorEditFormCycle)
            $deviceSensorEditFormCycle = new DeviceSensorEditFormCycle(false, new DeviceSensorEditForm());
        else if ($editing)
            $deviceSensorEditFormCycle->setEditingActive(true);

        $request->session()->put('deviceSensorEditFormCycle', $deviceSensorEditFormCycle);

        return view("layouts.device.edit")
            ->with("device", $this->getDeviceWhereUuidEquals($deviceUuid))
            ->with("sensors", Types::SENSORS())
            ->with("sensorTypes", Types::SENSOR_TYPES())
            ->with("relatedSensors", $this->getSensorWhereDeviceUuidEquals($deviceUuid))
            ->with("deviceSensorEditFormCycle", $deviceSensorEditFormCycle);
    }

    /**
     * @param mixed $deviceUuid
     * @return Collection
     */
    private function getSensorWhereDeviceUuidEquals(mixed $deviceUuid): Collection
    {
        return DB::table("sensor")->where("device_uuid", "=", $deviceUuid)->get();
    }

    /**
     * @param mixed $deviceUuid
     * @return Model|null
     */
    private function getDeviceWhereUuidEquals(mixed $deviceUuid): null|Model
    {
        return Device::query()->where('uuid', '=', $deviceUuid)->first();
    }

    /**
     * @param Request $request
     * @return null|DeviceSensorEditFormCycle
     */
    private function getDeviceSensorEditFormCycleSessionObject(Request $request): null|DeviceSensorEditFormCycle
    {
        return $request->session()->get("deviceSensorEditFormCycle");
    }

}
