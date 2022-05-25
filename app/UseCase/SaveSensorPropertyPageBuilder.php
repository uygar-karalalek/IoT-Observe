<?php


namespace App\UseCase;


use App\FormCycle\DeviceSensorProperty;
use Illuminate\Http\Request;

class SaveSensorPropertyPageBuilder extends EditPageBuilder
{

    public function toSaveSensorProperty(Request $request, mixed $deviceUuid): mixed
    {
        $deviceSensorEditFormCycle = $request->session()->get("deviceSensorEditFormCycle");

        $soil = $request->input("soil_value");
        $soilId = $request->input("soil_id");
        $operator = $request->input("operator");
        $aggregationLogic = $request->input("aggregation_logic" . $soilId);
        $sensorId = $request->input("sensor_id");

        $deviceSensorProperty = new DeviceSensorProperty($sensorId, $soilId, $soil, $operator, $aggregationLogic);
        $deviceSensorProperty->persist(update: true);

        $deviceSensorEditFormCycle->getSensors()[$sensorId]->getProps()
            ->getProperties()[$deviceSensorProperty->getId()]->copyFrom($deviceSensorProperty);

        return $this->editViewBuilderUseCase->editView($deviceSensorEditFormCycle)
            ->with("device", $this->deviceRepository->getDeviceWhereUuidEquals($deviceUuid));
    }

}
