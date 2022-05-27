<?php


namespace App\UseCase;


use App\FormCycle\DeviceSensorEditForm;
use App\FormCycle\DeviceSensorEditFormCycle;
use App\FormCycle\DeviceSensorProperty;
use App\Models\Device;
use App\Repository\DeviceRepository;
use App\Repository\SensorRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RemovePageBuilder extends EditPageBuilder
{

    public function apply(string $deviceUuid)
    {
        $this->sensorRepository->removeWhereDeviceUuid($deviceUuid);

        $devices = Device::query()->where("user_id", "=", Auth::user()->getAuthIdentifier())->get();

        return view('home')
            ->with("devices", $devices);
    }

}
