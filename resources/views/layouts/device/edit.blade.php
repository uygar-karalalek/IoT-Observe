@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Editing device "' . $device->name.'"') }}</div>
                    <div class="card-body">
                        <form method="post" action="#">
                            @csrf
                            <table>
                                <tr>
                                    <td>Name:</td>
                                    <td><input type="text" value="Name"></td>
                                </tr>
                                <tr>
                                    <td>Device type:</td>
                                    <td><label>{{$device->type}}</label></td>
                                </tr>
                                <tr>
                                    <td><h3 style="padding-top: 40px">Sensors</h3></td>
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
