<?php


namespace App\Repository;


use App\Models\Device;
use Illuminate\Database\Eloquent\Model;

class DeviceRepository
{

    public function getDeviceWhereUuidEquals(mixed $deviceUuid): null|Model
    {
        return Device::query()->where('uuid', '=', $deviceUuid)->first();
    }

}

