@if(!$deviceSensorEditFormCycle->isEditingActive())
    <form action="#" method="post" name="addSensor">
        <input type="hidden" name="device_uuid" value="{{$device->uuid}}">
        <input type="hidden" name="editing" value="true">
        <input type="submit" value="Add sensor">
        <input type="hidden" name="request_type" value="addSensor">
    </form>
@endif

@foreach($deviceSensorEditFormCycle->getSensors() as $sensor)

    @if ($deviceSensorEditFormCycle->isEditingActive() &&
            $deviceSensorEditFormCycle->getEditingSensor()->getId() == $sensor->getId())
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
    @else
                <form method="post" action="#">
                    @csrf
                    <table>
                        <tr>
                            <td>Sensor of type: {{$sensor->getType()}}</td>
                            <td>
                                <button type="submit" name="request_type" value="addSensorProperty">+</button>
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

    @endif
@endforeach
<br>
<script>
    function changeTheUnit(selected) {
        let arr = {!! json_encode($sensorKeyAndTypes) !!};
        let sensorTypes = document.getElementsByClassName("sensor_type");
        for (let i = 0; i < sensorTypes.length; i++) {
            sensorTypes[i].innerHTML = arr[selected.value].unit;
        }
    }
</script>
<br>
