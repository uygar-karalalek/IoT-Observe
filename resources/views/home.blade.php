@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 createDeviceTab">
                <div class="card">
                    <div class="card-header">{{ __('Create Device') }}</div>
                    <div class="card-body">
                        <form method="post" action="/devices/create">
                            {{ csrf_field() }}
                            <table>
                                <tr>
                                    <td>Device name{{ __(": ") }}</td>
                                    <td>
                                        <select id="deviceName" onchange="fillDeviceType()" name="deviceName">
                                        </select>
                                    </td>
                                </tr>
                                <tr style="height: 50px" class="device-type-row">
                                    <td>
                                        Device type:
                                    </td>
                                    <td>
                                        <input type="text" name="deviceType" id="devType" readonly/>
                                    </td>
                                </tr>
                                <tr class="create-device-row">
                                    <td>
                                        <input id="createDevice" type="submit" value="Create">
                                    </td>
                                </tr>
                            </table>
                            <script>
                                let devices = null;

                                function fillDeviceType() {
                                    let deviceName = document.getElementById("deviceName").value;
                                    devices.forEach(device => {
                                        if (device.name === deviceName) {
                                            document.getElementById("devType").value = device.type

                                        }
                                    })
                                }

                                setInterval(function () {
                                    axios.get("http://localhost:8081/api/fetchAllDevices/{{\Illuminate\Support\Facades\Auth::user()->id}}?secret=THIS_IS_A_SECRET", {
                                        headers: {
                                            'Access-Control-Allow-Origin': '*',
                                            'Content-Type': 'application/json',
                                            'Access-Control-Allow-Methods': 'GET,PUT,POST,DELETE,PATCH,OPTIONS',
                                        }
                                    }).then(value => {
                                        if (devices == null || value.data.length !== devices.length) {
                                            document.getElementById("deviceName").innerHTML = "";
                                            devices = value.data;
                                            axios.post("http://127.0.0.1:8000/clientDevices/toProcess", devices, {
                                                headers: {
                                                    'Content-Type': 'application/json'
                                                }
                                            }).then(filteredDevices => {
                                                if (filteredDevices.data.length === 0) {
                                                    document.getElementById("createDevice").disabled = true;
                                                } else {
                                                    document.getElementById("createDevice").disabled = false;
                                                    filteredDevices.data.forEach(device => {
                                                        document.getElementById("deviceName").innerHTML += "<option value='" + device.name + "'>" + device.name + "</option>"
                                                    })
                                                    fillDeviceType()
                                                }
                                            })
                                        }
                                    })
                                }, 1000)
                            </script>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">{{ __('Devices') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @for($i = 0; $i < count($devices); $i++)
                            <script>
                                setInterval(function () {
                                    axios.get("http://localhost:8081/api/fetchAllSensors/user/{{\Illuminate\Support\Facades\Auth::user()->id}}/device/{{$devices[$i]->name}}?secret=THIS_IS_A_SECRET",
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
                                                axios.post("http://127.0.0.1:8000/process/{{$devices[$i]->uuid}}/sensors", httpData, {
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
                            <div class="card">
                                <div class="card">
                                    <div class="card-body" style="width: 100%">
                                        <form method="post" action="/device/edit" name="edit_device[{{$i}}]">
                                            @csrf
                                            <input type="hidden" value="{{$devices[$i]->uuid}}" name="device_uuid">

                                            <input type="hidden" name="request_type" value="editDevice">
                                        </form>
                                        <script>
                                            function editDeviceNum{{$i}}() {
                                                document.forms.namedItem("edit_device[{{$i}}]").submit()
                                            }
                                        </script>
                                        <h5 class="card-title">Device {{$devices[$i]->name}}</h5>
                                        <a class="btn btn-primary" onclick="{{ "editDeviceNum" . $i }}()">
                                            Edit the device
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="margin-top: 0px">
                <div class="card">
                    <div class="card-header">{{ __('Messages') }}
                        <button onclick="clearMessages()">Clear</button>
                    </div>
                    <div id="body" class="card-body">
                    </div>

                    <script>
                        let messages = null
                        setInterval(function () {
                            axios.get("http://127.0.0.1:8000/user/{{\Illuminate\Support\Facades\Auth::user()->id}}/messages").then(value => {
                                let httpMessages = value.data;
                                let offset = messages == null ? httpMessages.length : httpMessages.length - messages.length;
                                if (messages == null || offset !== 0) {
                                    messages = httpMessages
                                    for (let i = httpMessages.length - offset; i < httpMessages.length; i++)
                                        document.getElementById("body").innerHTML += httpMessages[i]["content"] + "<br>";
                                }
                            })
                        }, 2000)

                    </script>
                </div>
            </div>
        </div>
        <script>
            function clearMessages() {
                axios.get("http://127.0.0.1:8000/user/{{\Illuminate\Support\Facades\Auth::user()->id}}/messages/delete")
                document.getElementById("body").innerHTML = "";
            }
        </script>
@endsection
