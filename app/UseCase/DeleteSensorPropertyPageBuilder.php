<?php


namespace App\UseCase;


use Illuminate\Support\Facades\DB;

class DeleteSensorPropertyPageBuilder extends EditPageBuilder
{

    public function deleteSensorProperty(mixed $deviceUuid)
    {
        $deviceSensorEditFormCycle = $this->request->session()->get("deviceSensorEditFormCycle");
        $sensorId = $this->request->input("sensor_id");

        $soilId = $this->request->input("soil_id");
        $deviceSensorEditFormCycle->getSensors()[$sensorId]->removeProperty($soilId);
        DB::table("sensor_soil")->where("id", "=", $soilId)->delete();

        return $this->editViewBuilderUseCase->editView($deviceSensorEditFormCycle)
            ->with("device", $this->deviceRepository->getDeviceWhereUuidEquals($deviceUuid));
    }

}
