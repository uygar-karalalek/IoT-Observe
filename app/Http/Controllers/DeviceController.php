<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Repository\DeviceRepository;
use App\Repository\SensorRepository;
use App\UseCase\EditViewBuilder;
use App\UseCase\RequestViewDispatcher;
use Faker\Core\Uuid;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

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
            new DeviceRepository(), new EditViewBuilder());
        return $requestViewDispatcher->apply($request);
    }

    public function clientDevicesToProcess(Request $request)
    {
        $devicesExclude = Device::query()->where("user_id", "=", Auth::user()->getAuthIdentifier())->get()->all();
        $devicesToFilter = $request->all();
        $filtered = [];
        foreach ($devicesToFilter as $device) {
            $existsInDb = false;
            foreach ($devicesExclude as $dbDevice) {
                if ($dbDevice["name"] == $device["name"]) {
                    $existsInDb = true;
                    break;
                }
            }
            if (!$existsInDb) $filtered[] = $device;
        }
        return $filtered;
    }

}
