<?php


namespace App\UseCase;


use Illuminate\Contracts\View\View;

class RemoveSensorPageBuilder extends EditPageBuilder
{

    public function toRemoveSensor(mixed $deviceUuid): View
    {
        $deviceSensorEditFormCycle = $this->request->session()->get("deviceSensorEditFormCycle");
        $sensorId = $this->request->input("sensor_id");
        if ($deviceSensorEditFormCycle->isAddingSensor() && $deviceSensorEditFormCycle->getAddingSensor()->getId() == $sensorId)
            $deviceSensorEditFormCycle->setAddingSensor(null);

        $deviceSensorEditFormCycle->removeSensorByIdFromDb($sensorId);
        $deviceSensorEditFormCycle->deleteSensor($sensorId);

        return $this->editViewBuilderUseCase->editView($deviceSensorEditFormCycle)
            ->with("device", $this->deviceRepository->getDeviceWhereUuidEquals($deviceUuid));
    }

}
