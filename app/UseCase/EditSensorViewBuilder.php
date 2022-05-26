<?php

namespace App\UseCase;

class EditSensorViewBuilder extends EditPageBuilder
{

    public function getView(string $deviceUuid): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $deviceSensorEditFormCycle = $this->request->session()->get("deviceSensorEditFormCycle");
        $sensorId = $this->request->input("sensor_id");
        $deviceSensorEditFormCycle->getSensors()[$sensorId]->setEditing(true);
        return $this->editViewBuilderUseCase->editView($deviceSensorEditFormCycle)->
                with("device", $this->deviceRepository->getDeviceWhereUuidEquals($deviceUuid));
    }

}
