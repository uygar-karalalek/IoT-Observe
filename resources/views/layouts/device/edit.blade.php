@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @include("script.device_react")
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
