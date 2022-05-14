@if(count($deviceSensorEditFormCycle->getSensors()) == 0)
    <form action="#" method="post" name="addSensor">
        <input type="hidden" name="device_uuid" value="{{$device->uuid}}">
        <input type="hidden" name="editing" value="true">
        <input type="submit" value="Add sensor">
        <input type="hidden" name="request_type" value="addSensor">
    </form>
@else
    <form action="#" method="post">
        <table>
            <tr>@include("layouts.device.sensor_props_actions")</tr>
            <input type="hidden" name="device_uuid" value="{{$device->uuid}}">
        </table>
    </form>
@endif

@foreach($deviceSensorEditFormCycle->getSensors() as $sensor)
    @if ($deviceSensorEditFormCycle->isEditingActive() &&
            $deviceSensorEditFormCycle->getEditingSensor()->getId() == $sensor->getId())
        <form action="#" method="post">
            <table>
                <tr>@include("layouts.device.sensor_prop")</tr>

                <input type="hidden" name="device_uuid" value="{{$device->uuid}}">
            </table>
        </form>
        <script>
            function changeTheUnit(selected) {
                let arr = {!! json_encode($sensorKeyAndTypes) !!};
                let sensorTypes = document.getElementsByClassName("sensor_type");
                for (let i = 0; i < sensorTypes.length; i++) {
                    sensorTypes[i].innerHTML = arr[selected.value].unit;
                }
            }
        </script>
    @else
        <form action="#" method="post">
            {{$sensor->getId()}}
        </form>
    @endif
@endforeach
<br>
<br>
