<?php


namespace App\UseCase;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeleteSensorPropertyPageBuilder extends EditPageBuilder
{

    public function deleteSensorProperty(mixed $deviceUuid, Request $request)
    {
        $deviceSensorEditFormCycle = $request->session()->get("deviceSensorEditFormCycle");
        $sensorId = $request->input("sensor_id");

        $soilId = $request->input("soil_id");
        $deviceSensorEditFormCycle->getSensors()[$sensorId]->removeProperty($soilId);
        DB::table("sensor_soil")->where("id", "=", $soilId)->delete();

        return $this->editViewBuilderUseCase->editView($deviceSensorEditFormCycle)
            ->with("device", $this->deviceRepository->getDeviceWhereUuidEquals($deviceUuid));
    }

}
