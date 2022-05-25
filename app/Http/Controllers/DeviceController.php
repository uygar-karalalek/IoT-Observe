<?php

namespace App\Http\Controllers;

use App\FormCycle\DeviceSensorEditForm;
use App\FormCycle\DeviceSensorEditFormCycle;
use App\FormCycle\DeviceSensorProperty;
use App\Models\Device;
use App\Models\Sensor;
use App\Repository\DeviceRepository;
use App\Repository\SensorRepository;
use App\Types\Operators;
use App\Types\Types;
use App\UseCase\EditViewBuilderUseCase;
use App\UseCase\RequestViewDispatcher;
use App\Utils\DbUtils;
use Faker\Core\Uuid;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeviceController extends Controller
{

    public function addDevice(Request $request): Redirector|Application|RedirectResponse
    {
        $devName = $request->input("deviceName");
        $type = $request->input("deviceType");
        $device = new Device();
        $device->uuid = (new Uuid())->uuid3();
        $device->name = $devName;
        $device->type = $type;
        $device->setCreatedAt(now());
        $device->setUpdatedAt(now());
        $device->setUpdatedAt(now());
        $device->user_id = Auth::user()->id;
        $device->save();

        return redirect("/");
    }

    public function editDevice(Request $request)
    {
        $requestViewDispatcher = new RequestViewDispatcher(new SensorRepository(),
            new DeviceRepository(), new EditViewBuilderUseCase());
        return $requestViewDispatcher->apply($request);
    }

}
