<?php

namespace App\UseCase;

class EditSensorViewBuilder extends EditPageBuilder
{

    public function getView(int $deviceUuid)
    {
        $deviceSensorEditFormCycle = $this->request->session()->get("deviceSensorEditFormCycle");
        $sensorId = $this->request->input("sensor_id");
        $deviceSensorEditFormCycle->getSensors()[$sensorId]->setEditing(true);
        return $this->editViewBuilderUseCase->editView($deviceSensorEditFormCycle)->
                with("device", $this->deviceRepository->getDeviceWhereUuidEquals($deviceUuid));
    }

}
