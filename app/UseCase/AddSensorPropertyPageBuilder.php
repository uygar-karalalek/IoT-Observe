<?php


namespace App\UseCase;


use App\FormCycle\DeviceSensorProperty;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AddSensorPropertyPageBuilder extends EditPageBuilder
{

    private function toAddSensorProperty(Request $request, mixed $deviceUuid): View
    {
        $deviceSensorEditFormCycle = $request->session()->get("deviceSensorEditFormCycle");
        $sensorId = $request->input("sensor_id");

        $deviceSensorProperty = new DeviceSensorProperty($sensorId);
        $deviceSensorProperty->persist();

        $deviceSensorEditFormCycle->getSensors()[$sensorId]->getProps()->add($deviceSensorProperty);

        return $this->editViewBuilderUseCase->editView($deviceSensorEditFormCycle)
            ->with("device", $this->deviceRepository->getDeviceWhereUuidEquals($deviceUuid));
    }

}
