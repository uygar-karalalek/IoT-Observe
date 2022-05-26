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
                            @include("script.devicesPanel_react")
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
                            @include("script.device_react")
                            <div class="card">
                                <div class="card">
                                    <div class="card-body" style="width: 100%">
                                        <form method="post" action="/device/edit" name="edit_device[{{$i}}]">
                                            @csrf
                                            <input type="hidden" value="{{$devices[$i]->uuid}}" name="device_uuid">

                                            <input type="hidden" name="request_type" value="editDevice">
                                        </form>

                                        <script>function editDeviceNum{{$i}}() {document.forms.namedItem("edit_device[{{$i}}]").submit()}</script>

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
                        window.deviceUserId = {{\Illuminate\Support\Facades\Auth::user()->id}}
                    </script>
                    <script src="{{ asset('js/messages_react.js') }}"></script>
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
