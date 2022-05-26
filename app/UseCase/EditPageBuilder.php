<?php


namespace App\UseCase;


use App\Repository\DeviceRepository;
use App\Repository\SensorRepository;
use Illuminate\Http\Request;

abstract class EditPageBuilder
{

    protected Request $request;
    protected SensorRepository $sensorRepository;
    protected DeviceRepository $deviceRepository;
    protected EditViewBuilder $editViewBuilderUseCase;

    /**
     * EditPageBuilder constructor.
     * @param Request $request
     * @param SensorRepository $sensorRepository
     * @param DeviceRepository $deviceRepository
     * @param EditViewBuilder $editViewBuilderUseCase
     */
    public function __construct(Request $request, SensorRepository $sensorRepository,
                                DeviceRepository $deviceRepository, EditViewBuilder $editViewBuilderUseCase)
    {
        $this->request = $request;
        $this->sensorRepository = $sensorRepository;
        $this->deviceRepository = $deviceRepository;
        $this->editViewBuilderUseCase = $editViewBuilderUseCase;
    }

}
