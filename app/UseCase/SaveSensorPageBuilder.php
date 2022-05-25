<?php


namespace App\UseCase;


use App\Models\Builder\SensorBuilder;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SaveSensorPageBuilder extends EditPageBuilder
{

    private function build(Request $request, mixed $deviceUuid): View
    {
        $deviceSensorEditFormCycle = $this->request->session()->get("deviceSensorEditFormCycle");

        $sensorType = $request->input("sensor_type");
        $sensorId = $request->input("sensor_id");
        $sensor = (new SensorBuilder())
                    ->withId($this->sensorRepository->getNextSensorId())
                    ->withDeviceUuid($deviceUuid)->withType($sensorType)
                    ->build();

        $sensor->save();

        $deviceSensorEditFormCycle->getSensors()[$sensorId]->setType($sensorType);

        $deviceSensorEditFormCycle->setAddingSensor(null);

        return $this->editViewBuilderUseCase->editView($deviceSensorEditFormCycle)
            ->with("device", $this->deviceRepository->getDeviceWhereUuidEquals($deviceUuid));
    }

}
