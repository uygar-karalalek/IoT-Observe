<?php


namespace App\UseCase;


use App\FormCycle\DeviceSensorProperty;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class SaveSensorPropertyPageBuilder extends EditPageBuilder
{

    public function toSaveSensorProperty(mixed $deviceUuid): Application|Factory|View
    {
        $deviceSensorEditFormCycle = $this->request->session()->get("deviceSensorEditFormCycle");

        $soil = $this->request->input("soil_value");
        $soilId = $this->request->input("soil_id");
        $operator = $this->request->input("operator");
        $aggregationLogic = $this->request->input("aggregation_logic" . $soilId);
        $sensorId = $this->request->input("sensor_id");

        $deviceSensorProperty = new DeviceSensorProperty($sensorId, $soilId, $soil, $operator, $aggregationLogic);
        $deviceSensorProperty->persist(update: true);

        $deviceSensorEditFormCycle->getSensors()[$sensorId]->getProps()
            ->getProperties()[$deviceSensorProperty->getId()]->copyFrom($deviceSensorProperty);

        return $this->editViewBuilderUseCase->editView($deviceSensorEditFormCycle)
            ->with("device", $this->deviceRepository->getDeviceWhereUuidEquals($deviceUuid));
    }

}
