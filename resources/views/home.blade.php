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
                                        <input type="text" name="deviceName">
                                    </td>
                                </tr>
                                <tr style="height: 50px" class="device-type-row">
                                    <td>
                                        Device type:
                                    </td>
                                    <td>
                                        <select name="deviceType">
                                            <option value="Phone">Phone</option>
                                            <option value="Arduino">Arduino</option>
                                            <option value="PC">PC</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="create-device-row">
                                    <td>
                                        <input type="submit" value="Create">
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Devices') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @for($i = 0; $i < count($devices); $i++)
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
        </div>
    </div>
@endsection
