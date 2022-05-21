@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <script>
                        setInterval(function () {
                            axios.get("http://localhost:8081/api/fetchAllSensors/user/{{\Illuminate\Support\Facades\Auth::user()->id}}/device/{{$device->name}}?secret=THIS_IS_A_SECRET",
                                {
                                    headers: {
                                        'Access-Control-Allow-Origin': '*',
                                        'Content-Type': 'application/json',
                                        'Access-Control-Allow-Methods': 'GET,PUT,POST,DELETE,PATCH,OPTIONS',
                                    }
                                })
                                .then(sensors => {
                                        let httpData = sensors.data;
                                        console.log(httpData)
                                        axios.post("http://127.0.0.1:8000/process/{{$device->uuid}}/sensors", httpData, {
                                            headers: {
                                                'Access-Control-Allow-Origin': '*',
                                                'Content-Type': 'application/json',
                                                'Access-Control-Allow-Methods': 'GET,PUT,POST,DELETE,PATCH,OPTIONS',
                                            }
                                        })
                                    }
                                );
                        }, 1000)
                    </script>
                    <div class="card-header">{{ __('Editing device "' . $device->name.'"') }}</div>
                    <div class="card-body">
                        <form method="post" action="#">
                            @csrf
                            <table>
                                <tr>
                                    <td>Device type: <label>{{$device->type}}</label></td>
                                </tr>
                                <tr>
                                    <td><h3 style="padding-top: 40px">Sensors & properties</h3></td>
                                </tr>
                                <tr>
                                    <td>@include('layouts.device.edit_sensor')</td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
