<?php

namespace App\Http\Controllers;

use App\FormCycle\DeviceSensorEditForm;
use App\FormCycle\DeviceSensorPropertiesEditForm;
use App\FormCycle\DeviceSensorEditFormCycle;
use App\Models\Device;
use App\Models\Sensor;
use App\Types\Operators;
use App\Types\Types;
use Faker\Core\Uuid;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeviceController extends Controller
{

    public function addDevice(Request $request): Redirector|Application|RedirectResponse
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

            if($requestType == "editDevice") {
                return $this->editDevicePage($deviceUuid, $request);
            }
            else if ($requestType == "addSensor") {
                return $this->toAddSensor($deviceUuid, $request);
            }
            if ($requestType == "saveSensorProperty") {
                $deviceSensorEditFormCycle = $this->getDeviceSensorEditFormCycleSessionObject($request);
                //$deviceSensorEditFormCycle->getSensors()
                return "X";
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
    private function editDevicePage(mixed $deviceUuid, Request $request): Application|Factory|View
    {
        $deviceSensorEditFormCycle = $this->getDeviceSensorEditFormCycleSessionObject($request);

        if (!$deviceSensorEditFormCycle)
            $deviceSensorEditFormCycle = new DeviceSensorEditFormCycle();


        $sensors = $this->getSensorsWhereDeviceUuidEquals($deviceUuid);
        foreach ($sensors as $sensor) $deviceSensorEditFormCycle->getSensors()[] = $sensor;

        $device = $this->getDeviceWhereUuidEquals($deviceUuid);

        $request->session()->put('deviceSensorEditFormCycle', $deviceSensorEditFormCycle);

        return $this->editView($deviceSensorEditFormCycle)
            ->with("device", $device);
    }

    public function getNewSensor(int $newId, string $deviceUuid): Sensor {
        $newSensor = new Sensor();
        $newSensor->id = $newId;
        $newSensor->type = Types::SENSOR_TYPES()[1]->getUnit();
        $newSensor->device_uuid = $deviceUuid;
        return $newSensor;
    }

    /**
     * @param mixed $deviceUuid
     * @return Collection
     */
    private function getSensorsWhereDeviceUuidEquals(mixed $deviceUuid): Collection
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

    /**
     * @param DeviceSensorEditFormCycle $deviceSensorEditFormCycle
     * @return Application|Factory|View
     */
    private function editView(DeviceSensorEditFormCycle $deviceSensorEditFormCycle): Application|Factory|View
    {
        return view("layouts.device.edit")
            ->with("sensorKeyAndTypes", Types::SENSOR_KEY_AND_TYPES())
            ->with("sensorTypes", Types::SENSOR_TYPES())
            ->with("deviceSensorEditFormCycle", $deviceSensorEditFormCycle);
    }

    /**
     * @param mixed $deviceUuid
     * @return int
     */
    private function getNextSensorId(mixed $deviceUuid): int
    {
        $max = DB::table("sensor")->select()->where("device_uuid", "=", $deviceUuid)->max("id");
        return 1 + ($max ?? 0);
    }

    /**
     * @param mixed $deviceUuid
     * @param Request $request
     * @return View
     */
    private function toAddSensor(mixed $deviceUuid, Request $request): string|View
    {
        $sensors = $this->getSensorsWhereDeviceUuidEquals($deviceUuid);
        $deviceSensorEditFormCycle = $this->getDeviceSensorEditFormCycleSessionObject($request);

        foreach ($sensors as $sensor) $deviceSensorEditFormCycle->getSensors()[] = $sensor;

        $nextSensorId = $this->getNextSensorId($deviceUuid);
        $newSensor = $this->getNewSensor($nextSensorId, $deviceUuid);


        $deviceSensorEditFormCycle->addSensor(DeviceSensorEditForm::fromSensorModel($newSensor));
        $deviceSensorEditFormCycle->setEditingSensor(DeviceSensorEditForm::fromSensorModel($newSensor));

        return $this->editView($deviceSensorEditFormCycle)
            ->with("device", $this->getDeviceWhereUuidEquals($deviceUuid))
            ->with("operators", Operators::OPERATORS());
    }

}
