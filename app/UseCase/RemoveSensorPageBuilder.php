<?php


namespace App\UseCase;


use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class RemoveSensorPageBuilder extends EditPageBuilder
{

    private function toRemoveSensor(Request $request, mixed $deviceUuid): View
    {
        $deviceSensorEditFormCycle = $request->session()->get("deviceSensorEditFormCycle");
        $sensorId = $request->input("sensor_id");
        if ($deviceSensorEditFormCycle->isAddingSensor() && $deviceSensorEditFormCycle->getAddingSensor()->getId() == $sensorId)
            $deviceSensorEditFormCycle->setAddingSensor(null);

        $deviceSensorEditFormCycle->removeSensorByIdFromDb($sensorId);
        $deviceSensorEditFormCycle->deleteSensor($sensorId);

        return $this->editViewBuilderUseCase->editView($deviceSensorEditFormCycle)
            ->with("device", $this->deviceRepository->getDeviceWhereUuidEquals($deviceUuid));
    }

}
