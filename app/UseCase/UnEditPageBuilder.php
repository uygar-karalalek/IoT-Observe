<?php


namespace App\UseCase;


use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class UnEditPageBuilder extends EditPageBuilder
{

    public function toUnEditSensor(Request $request, mixed $deviceUuid): View
    {
        $deviceSensorEditFormCycle = $request->session()->get("deviceSensorEditFormCycle");
        $sensorId = $request->input("sensor_id");
        $deviceSensorEditFormCycle->getSensors()[$sensorId]->setEditing(false);
        return $this->editViewBuilderUseCase->editView($deviceSensorEditFormCycle)
            ->with("device", $this->deviceRepository->getDeviceWhereUuidEquals($deviceUuid));
    }

}
