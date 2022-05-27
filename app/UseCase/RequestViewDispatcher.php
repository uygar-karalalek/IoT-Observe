<?php

namespace App\UseCase;

use App\Repository\DeviceRepository;
use App\Repository\SensorRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class RequestViewDispatcher
{

    protected Request $request;
    protected SensorRepository $sensorRepository;
    protected DeviceRepository $deviceRepository;
    protected EditViewBuilder $editViewBuilderUseCase;

    /**
     * RequestDeviceEditUseCase constructor.
     * @param SensorRepository $sensorRepository
     * @param DeviceRepository $deviceRepository
     * @param EditViewBuilder $editViewBuilderUseCase
     */
    public function __construct(SensorRepository $sensorRepository,
                                DeviceRepository $deviceRepository,
                                EditViewBuilder $editViewBuilderUseCase)
    {
        $this->sensorRepository = $sensorRepository;
        $this->deviceRepository = $deviceRepository;
        $this->editViewBuilderUseCase = $editViewBuilderUseCase;
    }

    public function apply(Request $request): Factory|View|Application|null
    {
        $deviceUuid = $request->input("device_uuid");
        $requestType = $request->input("request_type");

        if ($deviceUuid) {
            switch ($requestType) {
                case "editDevice":return $this->getBasePageView($request, $deviceUuid);
                case "removeDevice":return $this->getRemovePageView($request, $deviceUuid);
                case "addSensor": return $this->addSensorView($request, $deviceUuid);
                case "saveSensor": return $this->saveSensorView($request, $deviceUuid);
                case "editSensor": return $this->getEditSensorView($request, $deviceUuid);
                case "unEditSensor": return $this->getToUnEditSensorView($request, $deviceUuid);
                case "saveSensorProperty": return $this->getSaveSensorPropertyPageView($request, $deviceUuid);
                case "addSensorProperty": return $this->getAddSensorPropertyView($request, $deviceUuid);
                case "removeSensor": return $this->getToRemoveSensorView($request, $deviceUuid);
                case "deleteSensorProperty": return $this->getDeleteSensorPropertyView($request, $deviceUuid);
            }
        }

        return null;
    }

    /**
     * @param Request $request
     * @param mixed $deviceUuid
     * @return Application|Factory|View
     */
    private function addSensorView(Request $request, mixed $deviceUuid): Application|Factory|View
    {
        return (new AddSensorPageBuilder($request, $this->sensorRepository, $this->deviceRepository, $this->editViewBuilderUseCase))->buildSensorPageView($deviceUuid);
    }

    /**
     * @param Request $request
     * @param mixed $deviceUuid
     * @return View
     */
    private function saveSensorView(Request $request, mixed $deviceUuid): View
    {
        return (new SaveSensorPageBuilder($request, $this->sensorRepository, $this->deviceRepository, $this->editViewBuilderUseCase))->getView($deviceUuid);
    }

    /**
     * @param Request $request
     * @param mixed $deviceUuid
     * @return Application|Factory|View
     */
    private function getEditSensorView(Request $request, mixed $deviceUuid): Application|Factory|View
    {
        return (new EditSensorViewBuilder($request, $this->sensorRepository, $this->deviceRepository, $this->editViewBuilderUseCase))->getView($deviceUuid);
    }

    /**
     * @param Request $request
     * @param string $deviceUuid
     * @return View
     */
    private function getToUnEditSensorView(Request $request, string $deviceUuid): View
    {
        return (new UnEditPageBuilder($request, $this->sensorRepository, $this->deviceRepository, $this->editViewBuilderUseCase))->toUnEditSensor($deviceUuid);
    }

    /**
     * @param Request $request
     * @param mixed $deviceUuid
     * @return View
     */
    private function getSaveSensorPropertyPageView(Request $request, mixed $deviceUuid): View
    {
        return (new SaveSensorPropertyPageBuilder($request, $this->sensorRepository, $this->deviceRepository, $this->editViewBuilderUseCase))
            ->toSaveSensorProperty($deviceUuid);
    }

    /**
     * @param Request $request
     * @param mixed $deviceUuid
     * @return View
     */
    private function getAddSensorPropertyView(Request $request, mixed $deviceUuid): View
    {
        return (new AddSensorPropertyPageBuilder($request, $this->sensorRepository, $this->deviceRepository, $this->editViewBuilderUseCase))->toAddSensorProperty($deviceUuid);
    }

    /**
     * @param Request $request
     * @param mixed $deviceUuid
     * @return View
     */
    private function getToRemoveSensorView(Request $request, mixed $deviceUuid): View
    {
        return (new RemoveSensorPageBuilder($request, $this->sensorRepository, $this->deviceRepository, $this->editViewBuilderUseCase))->toRemoveSensor($deviceUuid);
    }

    /**
     * @param Request $request
     * @param mixed $deviceUuid
     * @return Application|Factory|View
     */
    private function getDeleteSensorPropertyView(Request $request, mixed $deviceUuid): Application|Factory|View
    {
        return (new DeleteSensorPropertyPageBuilder($request, $this->sensorRepository, $this->deviceRepository, $this->editViewBuilderUseCase))->deleteSensorProperty($deviceUuid);
    }

    /**
     * @param Request $request
     * @param mixed $deviceUuid
     * @return Application|Factory|View
     */
    private function getBasePageView(Request $request, mixed $deviceUuid): Application|View|Factory
    {
        return (new BaseEditPageBuilder($request, $this->sensorRepository, $this->deviceRepository, $this->editViewBuilderUseCase))->apply($deviceUuid);
    }

    /**
     * @param Request $request
     * @param mixed $deviceUuid
     * @return Application|Factory|View
     */
    private function getRemovePageView(Request $request, mixed $deviceUuid): Application|View|Factory
    {
        return (new RemovePageBuilder($request, $this->sensorRepository, $this->deviceRepository, $this->editViewBuilderUseCase))->apply($deviceUuid);
    }

}
