<?php


namespace App\UseCase;


use App\FormCycle\DeviceSensorEditForm;
use App\Models\Builder\SensorBuilder;

class AddSensorPageBuilder extends EditPageBuilder
{

    public function buildSensorPageView(mixed $deviceUuid)
    {
        $deviceSensorEditFormCycle = $this->request->session()->get("deviceSensorEditFormCycle");

        if (!$deviceSensorEditFormCycle->isAddingSensor()) {
            $nextSensorId = $this->sensorRepository->getNextSensorId();
            $sensor = (new SensorBuilder())->withId($nextSensorId)->withDeviceUuid($deviceUuid);
            $editingSensor = DeviceSensorEditForm::fromSensorModel($sensor->build());

            $deviceSensorEditFormCycle->setAddingSensor($editingSensor);
            $deviceSensorEditFormCycle->addSensor($editingSensor);
        }

        return $this->editViewBuilderUseCase->editView($deviceSensorEditFormCycle)
                ->with("device", $this->deviceRepository->getDeviceWhereUuidEquals($deviceUuid));
    }

}
