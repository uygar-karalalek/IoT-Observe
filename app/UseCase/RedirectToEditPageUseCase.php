<?php


namespace App\UseCase;


use App\FormCycle\DeviceSensorEditForm;
use App\FormCycle\DeviceSensorEditFormCycle;
use App\FormCycle\DeviceSensorProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RedirectToEditPageUseCase
{

    private Request $request;

    /**
     * RedirectToEditPageUseCase constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(string $deviceUuid) {
        $deviceSensorEditFormCycle = $this->request->session()->get("deviceSensorEditFormCycle");

        if (!$deviceSensorEditFormCycle)
            $deviceSensorEditFormCycle = new DeviceSensorEditFormCycle();

        $deviceSensorEditFormCycle->setSensors([]);

        $sensors = $this->getSensorsWhereDeviceUuidEquals($deviceUuid);
        foreach ($sensors as $sensor) {
            $sensorEditForm = DeviceSensorEditForm::fromSensorModel($sensor);
            $props = DB::table("sensor_soil")->where("sensor_id", "=", $sensorEditForm->getId())->get();
            foreach ($props as $prop) {
                $deviceSensorProperty = DeviceSensorProperty::fromSoilModel($prop);
                $sensorEditForm->getProps()->add($deviceSensorProperty);
            }
            $deviceSensorEditFormCycle->addSensor($sensorEditForm);
        }

        $device = $this->getDeviceWhereUuidEquals($deviceUuid);

        $request->session()->put('deviceSensorEditFormCycle', $deviceSensorEditFormCycle);

        return $this->editView($deviceSensorEditFormCycle)
            ->with("device", $device);
    }

}
