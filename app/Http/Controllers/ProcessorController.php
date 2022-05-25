<?php


namespace App\Http\Controllers;


use App\Models\MessageModel;
use App\Utils\Processor;
use Illuminate\Http\Request;

class ProcessorController
{

    function process(Request $request)
    {
        $json = $request->all();
        foreach ($json as $deviceSensor) {
            $processor = new Processor($deviceSensor["type"]);
            $passed = $processor->process($deviceSensor['value']);
            if ($passed) {
                MessageModel::query()->insert([
                    "content" => "The client device sensor has reached the soil value of " . $deviceSensor["value"],
                    "created_at" => now(),
                    "updated_at" => now(),
                    "user_id" => 5
                ]);
            }
        }
    }

}
