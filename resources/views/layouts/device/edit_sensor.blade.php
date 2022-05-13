@if(count($relatedSensors) == 0)
    NO SENSOR FOUND
@else
    @foreach($relatedSensors as $sensor)

    @endforeach
@endif
<br>
<br>

@if($deviceSensorEditFormCycle->isEditingActive())
    <form action="#" method="post">
        <table>
            <tr>
                <td>Sensor type:</td>
                <td>
                    <select name="sensorType" onchange="changeTheUnit(this)">
                        @foreach($sensorTypes as $type)
                            <option name="{{$type->getKey()}}" value="{{$type->getKey()}}">{{$type->getKey()}}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="submit" name="submitOk" value="OK"></td>
                <td><input type="submit" name="submitCancel" value="X"></td>
            </tr>
            <tr>
                <td>Add soil</td>
                <td id="type">{{$sensorTypes[0]->getUnit()}}</td>
            </tr>

            <input type="hidden" name="device_uuid" value="{{$device->uuid}}">
            <input type="hidden" name="request_type" value="saveSensor">
        </table>
    </form>
    <script>
        function changeTheUnit(selected) {
            let arr = {!! json_encode($sensors) !!};
            document.getElementById("type").innerHTML = arr[selected.value].unit;
            console.log(arr)
        }
    </script>
@else
    <form action="#" method="post" name="addSensor">
        <input type="hidden" name="device_uuid" value="{{$device->uuid}}">
        <input type="hidden" name="editing" value="true">
        <input type="submit" value="Add sensor">
        <input type="hidden" name="request_type" value="goToAddSensorPage">
    </form>
@endif
