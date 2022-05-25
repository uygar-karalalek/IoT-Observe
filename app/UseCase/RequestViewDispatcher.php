<?php


namespace App\UseCase;


use App\Repository\DeviceRepository;
use App\Repository\SensorRepository;
use Illuminate\Http\Request;

class RequestViewDispatcher
{

    protected Request $request;
    protected SensorRepository $sensorRepository;
    protected DeviceRepository $deviceRepository;
    protected EditViewBuilderUseCase $editViewBuilderUseCase;

    /**
     * RequestDeviceEditUseCase constructor.
     * @param SensorRepository $sensorRepository
     * @param DeviceRepository $deviceRepository
     * @param EditViewBuilderUseCase $editViewBuilderUseCase
     */
    public function __construct(SensorRepository $sensorRepository,
                                DeviceRepository $deviceRepository,
                                EditViewBuilderUseCase $editViewBuilderUseCase)
    {
        $this->sensorRepository = $sensorRepository;
        $this->deviceRepository = $deviceRepository;
        $this->editViewBuilderUseCase = $editViewBuilderUseCase;
    }

    public function apply(Request $request)
    {
        $deviceUuid = $request->input("device_uuid");
        $requestType = $request->input("request_type");

        if ($deviceUuid) {
            switch ($requestType) {
                case "editDevice":return $this->getBasePageView($request, $deviceUuid);
                case "addSensor": return $this->addSensorView($request, $deviceUuid);
                case "saveSensor": return $this->saveSensorView($request, $deviceUuid);
                case "editSensor": return $this->getEditSensorView($request, $deviceUuid);
                case "unEditSensor": return $this->getToUnEditSensorView($request);
                case "saveSensorProperty": return $this->getSaveSensorPageView($request, $deviceUuid);
                case "addSensorProperty": return $this->getAddSensorPropertyView($request);
                case "removeSensor": return $this->getToRemoveSensorView($request);
                case "deleteSensorProperty": return $this->getDeleteSensorPropertyView($request, $deviceUuid);
            }
        }

        return null;
    }

    /**
     * @param Request $request
     * @param mixed $deviceUuid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    private function addSensorView(Request $request, mixed $deviceUuid): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return (new AddSensorPageBuilder($request, $this->sensorRepository, $this->deviceRepository, $this->editViewBuilderUseCase))->buildSensorPageView($deviceUuid);
    }

    /**
     * @param Request $request
     * @param mixed $deviceUuid
     * @return \Illuminate\Contracts\View\View
     */
    private function saveSensorView(Request $request, mixed $deviceUuid): \Illuminate\Contracts\View\View
    {
        return (new SaveSensorPageBuilder($request, $this->sensorRepository, $this->deviceRepository, $this->editViewBuilderUseCase))->getView($request, $deviceUuid);
    }

    /**
     * @param Request $request
     * @param mixed $deviceUuid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    private function getEditSensorView(Request $request, mixed $deviceUuid): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return (new EditSensorViewBuilder($request, $this->sensorRepository, $this->deviceRepository, $this->editViewBuilderUseCase))->getView($deviceUuid);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    private function getToUnEditSensorView(Request $request): \Illuminate\Contracts\View\View
    {
        return (new UnEditPageBuilder($request, $this->sensorRepository, $this->deviceRepository, $this->editViewBuilderUseCase))->toUnEditSensor();
    }

    /**
     * @param Request $request
     * @param mixed $deviceUuid
     * @return \Illuminate\Contracts\View\View
     */
    private function getSaveSensorPageView(Request $request, mixed $deviceUuid): \Illuminate\Contracts\View\View
    {
        return (new SaveSensorPageBuilder($request, $this->sensorRepository, $this->deviceRepository, $this->editViewBuilderUseCase))
            ->getView($deviceUuid);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    private function getAddSensorPropertyView(Request $request)
    {
        return (new AddSensorPropertyPageBuilder($request, $this->sensorRepository, $this->deviceRepository, $this->editViewBuilderUseCase))->toAddSensorProperty($this->deviceRepository);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    private function getToRemoveSensorView(Request $request): \Illuminate\Contracts\View\View
    {
        return (new RemoveSensorPageBuilder($request, $this->sensorRepository, $this->deviceRepository, $this->editViewBuilderUseCase))->toRemoveSensor($this->deviceRepository);
    }

    /**
     * @param Request $request
     * @param mixed $deviceUuid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    private function getDeleteSensorPropertyView(Request $request, mixed $deviceUuid): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return (new DeleteSensorPropertyPageBuilder($request, $this->sensorRepository, $this->deviceRepository, $this->editViewBuilderUseCase))->deleteSensorProperty($deviceUuid);
    }

    /**
     * @param Request $request
     * @param mixed $deviceUuid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    private function getBasePageView(Request $request, mixed $deviceUuid): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return (new BaseEditPageBuilder($request, $this->sensorRepository, $this->deviceRepository, $this->editViewBuilderUseCase))->apply($deviceUuid);
    }

}
