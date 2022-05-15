@if(!$deviceSensorEditFormCycle->isEditingActive())
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
            @csrf
            <table>
                @foreach($sensor->getProps()->getProperties() as $prop)
                    <tr>
                        <form action="#" method="post">
                            @csrf
                            @include("layouts.device.sensor_prop")
                        </form>
                    </tr>
                @endforeach

                <input type="hidden" name="sensor_id" value="{{$sensor->getId()}}">
                <input type="hidden" name="device_uuid" value="{{$device->uuid}}">
            </table>
        </form>
    @else
        <table>
            <tr>
                <td>Sensor of type: {{$sensor->getType()}}</td>
                <td>
                    <button type="submit"
                            name="request_type" value="addSensorProperty"
                        {{$deviceSensorEditFormCycle->isEditingActive() ? "disabled" : ""}}> +
                    </button>
                </td>
            </tr>

            @foreach($sensor->getProps()->getProperties() as $prop)
                <tr>
                    <form action="#" method="post">
                        @csrf
                        @include("layouts.device.sensor_prop")
                    </form>
                </tr>
            @endforeach

        </table>
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
