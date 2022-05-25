<?php


namespace App\UseCase;


use App\FormCycle\DeviceSensorEditFormCycle;
use App\Types\Operators;
use App\Types\Types;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class EditViewBuilderUseCase
{

    public function editView(DeviceSensorEditFormCycle $deviceSensorEditFormCycle): Application|Factory|View {
        return view("layouts.device.edit")
            ->with("sensorKeyAndTypes", Types::SENSOR_KEY_AND_TYPES())
            ->with("sensorTypes", Types::SENSOR_TYPES())
            ->with("deviceSensorEditFormCycle", $deviceSensorEditFormCycle)
            ->with("operators", Operators::OPERATORS());
    }

}
