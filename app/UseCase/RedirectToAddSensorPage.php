<?php


namespace App\UseCase;


use App\FormCycle\DeviceSensorEditForm;
use App\Models\Builder\SensorBuilder;
use App\Repository\DeviceRepository;
use App\Repository\SensorRepository;
use Illuminate\Http\Request;

class RedirectToAddSensorPage
{

    private Request $request;
    private SensorRepository $sensorRepository;
    private DeviceRepository $deviceRepository;
    private EditViewBuilderUseCase $editViewBuilderUseCase;

    /**
     * RedirectToAddSensorPage constructor.
     * @param Request $request
     * @param SensorRepository $sensorRepository
     * @param DeviceRepository $deviceRepository
     */
    public function __construct(Request $request,
                                SensorRepository $sensorRepository,
                                DeviceRepository $deviceRepository,
                                EditViewBuilderUseCase $editViewBuilderUseCase)
    {
        $this->request = $request;
        $this->sensorRepository = $sensorRepository;
        $this->deviceRepository = $deviceRepository;
        $this->editViewBuilderUseCase = $editViewBuilderUseCase;
    }

    public function buildView(mixed $deviceUuid)
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
