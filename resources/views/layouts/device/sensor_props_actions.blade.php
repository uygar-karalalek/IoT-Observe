<td>Sensor type:</td>
<td>
    <select name="sensorType" onchange="changeTheUnit(this)">
        @foreach($sensorTypes as $type)
            <option name="{{$type->getKey()}}"
                    value="{{$type->getKey()}}">{{$type->getKey()}}</option>
        @endforeach
    </select>
</td>
<td>
    <button type="submit" name="request_type" value="saveSensor">Ok</button>
</td>
<td>
    <button type="submit" name="request_type" value="addSensorProperty"> +</button>
</td>
<td>
    <button type="submit" name="request_type" value="resetSensor"> x</button>
</td>
