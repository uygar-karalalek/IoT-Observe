<?php

namespace App\Http\Controllers;

use App\FormCycle\DeviceSensorEditForm;
use App\FormCycle\DeviceSensorEditFormCycle;
use App\FormCycle\DeviceSensorProperty;
use App\Models\Device;
use App\Models\Sensor;
use App\Models\SensorSoil;
use App\Types\Operators;
use App\Types\Types;
use App\Utils\DbUtils;
use Faker\Core\Uuid;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
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
            if ($requestType == "editDevice") {
                return $this->editDevicePage($deviceUuid, $request);
            } else if ($requestType == "addSensor") {
                return $this->toAddSensor($deviceUuid, $request);
            } else if ($requestType == "saveSensor") {
                return $this->toSavedSensor($request, $deviceUuid);
            } else if ($requestType == "saveSensorProperty") {
                return $this->saveSensorProperty($request, $deviceUuid);
            } else if ($requestType == "addSensorProperty") {
                return $this->addSensorProperty($request, $deviceUuid);
            }  else if ($requestType == "removeSensor") {

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
    private function editDevicePage(mixed $deviceUuid, Request $request): string|Application|Factory|View
    {
        $deviceSensorEditFormCycle = $this->getDeviceSensorEditFormCycleSessionObject($request);

        if (!$deviceSensorEditFormCycle)
            $deviceSensorEditFormCycle = new DeviceSensorEditFormCycle();

        $deviceSensorEditFormCycle->setSensors([]);

        $sensors = $this->getSensorsWhereDeviceUuidEquals($deviceUuid);
        foreach ($sensors as $sensor) {
            $sensorEditForm = DeviceSensorEditForm::fromSensorModel($sensor);
            $props = DB::table("sensor_soil")->where("sensor_id", "=", $sensorEditForm->getId())->get();
            foreach ($props as $prop) $sensorEditForm->getProps()->add(DeviceSensorProperty::fromSoilModel($prop));
            $deviceSensorEditFormCycle->addSensor($sensorEditForm);
        }

        $device = $this->getDeviceWhereUuidEquals($deviceUuid);

        $request->session()->put('deviceSensorEditFormCycle', $deviceSensorEditFormCycle);

        return $this->editView($deviceSensorEditFormCycle)
            ->with("device", $device);
    }

    public function getNewSensor(int $newId, string $deviceUuid, $type = null): Sensor
    {
        if ($type == null) $type = Types::SENSOR_TYPES()[1]->getKey();

        $newSensor = new Sensor();
        $newSensor->id = $newId;
        $newSensor->type = $type;
        $newSensor->device_uuid = $deviceUuid;
        return $newSensor;
    }

    /**
     * @param mixed $deviceUuid
     * @return Sensor[]
     */
    private function getSensorsWhereDeviceUuidEquals(mixed $deviceUuid): array
    {
        $collection = DB::table("sensor")->where("device_uuid", "=", $deviceUuid)->get();
        $mappedSensors = [];
        foreach ($collection as $value) {
            $sensor = new Sensor();
            $sensor->id = $value->id;
            $sensor->type = $value->type;
            $sensor->device_uuid = $value->device_uuid;
            $sensor->created_at = $value->created_at;
            $sensor->updated_at = $value->updated_at;
            $mappedSensors[] = $sensor;
        }
        return $mappedSensors;
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
            ->with("deviceSensorEditFormCycle", $deviceSensorEditFormCycle)
            ->with("operators", Operators::OPERATORS());
    }

    /**
     * @param mixed $deviceUuid
     * @return int
     */
    private function getNextSensorId(mixed $deviceUuid): int
    {
        $max = DbUtils::getMaxId("sensor", "device_uuid", $deviceUuid);
        return 1 + ($max ?? 0);
    }

    /**
     * @param mixed $deviceUuid
     * @param Request $request
     * @return View
     */
    private function toAddSensor(mixed $deviceUuid, Request $request): View
    {
        $deviceSensorEditFormCycle = $this->getDeviceSensorEditFormCycleSessionObject($request);

        if (!$deviceSensorEditFormCycle->isEditingActive()) {
            $nextSensorId = $this->getNextSensorId($deviceUuid);
            $newSensor = $this->getNewSensor($nextSensorId, $deviceUuid);
            $editingSensor = DeviceSensorEditForm::fromSensorModel($newSensor);

            $deviceSensorEditFormCycle->setEditingSensor($editingSensor);
            $deviceSensorEditFormCycle->addSensor($editingSensor);
        }

        return $this->editView($deviceSensorEditFormCycle)
            ->with("device", $this->getDeviceWhereUuidEquals($deviceUuid));
    }

    /**
     * @param Request $request
     * @param mixed $deviceUuid
     * @return View
     */
    private function toSavedSensor(Request $request, mixed $deviceUuid): View
    {
        $deviceSensorEditFormCycle = $this->getDeviceSensorEditFormCycleSessionObject($request);

        $sensorType = $request->input("sensor_type");
        $sensor = $this->getNewSensor($this->getNextSensorId($deviceUuid), $deviceUuid, $sensorType);
        $sensor->save();

        $deviceSensorEditFormCycle->setEditingSensor(null);

        return $this->editView($deviceSensorEditFormCycle)->with("device", $this->getDeviceWhereUuidEquals($deviceUuid));
    }

    /**
     * @param Request $request
     * @param mixed $deviceUuid
     * @return View
     */
    private function saveSensorProperty(Request $request, mixed $deviceUuid): mixed
    {
        $deviceSensorEditFormCycle = $this->getDeviceSensorEditFormCycleSessionObject($request);
        $soil = $request->input("soil_value");
        $soilId = $request->input("soil_id");
        $operator = $request->input("operator");
        $aggregationLogic = $request->input("aggregation_logic".$soilId);
        $sensorId = $request->input("sensor_id");

        $deviceSensorProperty = new DeviceSensorProperty($sensorId, $soilId, $soil, $operator, $aggregationLogic);
        $deviceSensorProperty->persist(update: true);

        $deviceSensorEditFormCycle->getSensors()[$sensorId]->getProps()->getProperties()[$deviceSensorProperty->getId()]->copyFrom($deviceSensorProperty);

        return $this->editView($deviceSensorEditFormCycle)
            ->with("device", $this->getDeviceWhereUuidEquals($deviceUuid));
    }

    private function addSensorProperty(Request $request, mixed $deviceUuid): string|View
    {
        $deviceSensorEditFormCycle = $this->getDeviceSensorEditFormCycleSessionObject($request);
        $sensorId = $request->input("sensor_id");

        $deviceSensorProperty = new DeviceSensorProperty($sensorId);
        $deviceSensorProperty->persist();

        $deviceSensorEditFormCycle->getSensors()[$sensorId]->getProps()->add($deviceSensorProperty);

        return $this->editView($deviceSensorEditFormCycle)->with("device", $this->getDeviceWhereUuidEquals($deviceUuid));
    }

}
