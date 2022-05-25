<?php


namespace App\UseCase;


use App\FormCycle\DeviceSensorEditForm;
use App\FormCycle\DeviceSensorEditFormCycle;
use App\FormCycle\DeviceSensorProperty;
use App\Repository\DeviceRepository;
use App\Repository\SensorRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BaseEditPageBuilder extends EditPageBuilder
{

    public function apply(string $deviceUuid)
    {
        $deviceSensorEditFormCycle = $this->request->session()->get("deviceSensorEditFormCycle");

        if (!$deviceSensorEditFormCycle)
            $deviceSensorEditFormCycle = new DeviceSensorEditFormCycle();

        $deviceSensorEditFormCycle->setSensors([]);

        $sensors = $this->sensorRepository->getSensorsWhereDeviceUuidEquals($deviceUuid);
        foreach ($sensors as $sensor) {
            $sensorEditForm = DeviceSensorEditForm::fromSensorModel($sensor);
            $props = DB::table("sensor_soil")->where("sensor_id", "=", $sensorEditForm->getId())->get();
            foreach ($props as $prop) {
                $deviceSensorProperty = DeviceSensorProperty::fromSoilModel($prop);
                $sensorEditForm->getProps()->add($deviceSensorProperty);
            }
            $deviceSensorEditFormCycle->addSensor($sensorEditForm);
        }

        $device = $this->deviceRepository->getDeviceWhereUuidEquals($deviceUuid);

        $this->request->session()->put('deviceSensorEditFormCycle', $deviceSensorEditFormCycle);

        return
            $this->editViewBuilderUseCase
            ->editView($deviceSensorEditFormCycle)
            ->with("device", $device);
    }

}
