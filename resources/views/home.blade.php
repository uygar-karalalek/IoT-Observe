@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="container col-md-4">
                <div class="createDeviceTab">
                    <div class="card">
                        <div class="card-header"
                             style="background-color:#2c97ac; color: white">{{ __('Create Device') }}</div>
                        <div class="card-body" style="background: #22c1c3; background: -webkit-linear-gradient(to right, #fdbb2d, #22c1c3);background: linear-gradient(to right, #fdbb2d, #22c1c3);">
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
                                            <input style="background-color: blanchedalmond" type="text" name="deviceType" id="devType" readonly/>
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

                <div style="margin-top: 10px">
                    <div class="card">
                        <div class="card-header"
                             style="background-color:#2c97ac; color: white">{{ __('Messages') }}
                            <button onclick="clearMessages()">Clear</button>
                        </div>
                        <div id="body" class="card-body" style="background: #22c1c3; background: -webkit-linear-gradient(to right, #fdbb2d, #22c1c3);background: linear-gradient(to right, #fdbb2d, #22c1c3);">
                        </div>

                        <script>
                            window.deviceUserId = {{\Illuminate\Support\Facades\Auth::user()->id}}
                        </script>
                        <script src="{{ asset('js/messages_react.js') }}"></script>
                    </div>
                </div>

            </div>
            <div class="col-md-8">
                <div class="card" style="color: white;background: #0575E6;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #021B79, #0575E6);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #021B79, #0575E6); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
">
                    <div class="card-header" style="background: #0575E6;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #021B79, #0575E6);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #021B79, #0575E6); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
">{{ __('Devices') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @for($i = 0; $i < count($devices); $i++)
                            @include("script.device_react")
                            <div class="card" id="{{$devices[$i]->name}}">
                                <div class="card" style="color: white;background: -webkit-linear-gradient(to right, #2b72c4, #154092);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #0e2947, #154092); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */">

                                    <div class="card-body" style="height: 25vh; width: 100%">

                                        <form method="post" action="/device/edit" name="remove_device[{{$i}}]">
                                            @csrf
                                            <input type="hidden" value="{{$devices[$i]->uuid}}" name="device_uuid">
                                            <input type="hidden" name="request_type" value="removeDevice">
                                        </form>

                                        <form method="post" action="/device/edit" name="edit_device[{{$i}}]">
                                            @csrf
                                            <input type="hidden" value="{{$devices[$i]->uuid}}" name="device_uuid">
                                            <input type="hidden" name="request_type" value="editDevice">
                                        </form>

                                        <script>
                                            function editDeviceNum{{$i}}() {
                                                document.forms.namedItem("edit_device[{{$i}}]").submit()
                                            }

                                            function removeDeviceNum{{$i}}() {
                                                document.forms.namedItem("remove_device[{{$i}}]").submit()
                                            }
                                        </script>

                                        <h5 class="card-title">Device {{$devices[$i]->name}}</h5>
                                        <p id="text{{$devices[$i]->name}}" class="card-text text-device-connection">
                                            <span style="color: #e7a1a1"><u>Status: No connection</u></span></p>
                                        <a class="btn btn-primary" onclick="{{ "editDeviceNum" . $i }}()">
                                            <img src="{{asset("images/edit.png")}}" width="30px" alt="edit"/>
                                        </a>
                                        <a class="btn btn-primary" style="background-color: red"
                                           onclick="{{ "removeDeviceNum" . $i }}()">
                                            <img src="{{asset("images/remove.png")}}" width="30px" alt="remove"/>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
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
