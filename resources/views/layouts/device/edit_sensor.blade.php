<form action="#" method="post" name="addSensor">
    <input type="hidden" name="device_uuid" value="{{$device->uuid}}">
    <input type="hidden" name="editing" value="true">
    <input type="submit" value="Add sensor">
    <span id="span"></span>
    <input type="hidden" name="request_type" id="addSensorButton" value="addSensor">
</form>

@foreach($deviceSensorEditFormCycle->getSensors() as $sensor)
    <br>
    ________________________________________________________________________
    <br>
    <br>
    @if ($deviceSensorEditFormCycle->isAddingSensor() &&
            $deviceSensorEditFormCycle->getAddingSensor()->getId() == $sensor->getId())
        <form action="#" method="post">
            @csrf
            <table>
                <tr>@include("layouts.device.sensor_props_actions")</tr>
                <input type="hidden" name="device_uuid" value="{{$device->uuid}}">
                <input type="hidden" name="sensor_id" value="{{$sensor->getId()}}">
            </table>
            <input type="hidden" name="sensor_id" value="{{$sensor->getId()}}">
            <input type="hidden" name="device_uuid" value="{{$device->uuid}}">
        </form>
    @elseif($sensor->isEditing())
        <form method="post" action="#">
            @csrf
            <table>
                <tr>
                    <td>Sensor of type: {{$sensor->getType()}}</td>
                    <td>
                        <button type="submit" name="request_type" value="addSensorProperty">+</button>
                        <button type="submit" name="request_type" value="unEditSensor">unedit</button>
                        <button type="submit" name="request_type" value="removeSensor">x</button>
                    </td>
                </tr>
                <input type="hidden" name="sensor_id" value="{{$sensor->getId()}}">
                <input type="hidden" name="device_uuid" value="{{$device->uuid}}">
            </table>
        </form>

        @foreach($sensor->getProps()->getProperties() as $prop)
            <tr>
                <form action="#" method="post">
                    @csrf
                    @include("layouts.device.sensor_prop")
                </form>
            </tr>
        @endforeach
    @else
        <form action="#" method="post">
            @csrf
            <table>
                <tr>
                    <td>Sensor of type: {{$sensor->getType()}}</td>
                    <td>
                        <button type="submit" name="request_type" value="editSensor">Edit</button>
                        <button type="submit" name="request_type" value="removeSensor">x</button>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="sensor_id" value="{{$sensor->getId()}}">
            <input type="hidden" name="device_uuid" value="{{$device->uuid}}">
        </form>
    @endif
@endforeach
<br>
<br>
