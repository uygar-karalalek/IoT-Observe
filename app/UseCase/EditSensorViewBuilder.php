<?php


namespace App\UseCase;


use Illuminate\Http\Request;

class EditSensorViewBuilder extends BaseEditPageBuilder
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
