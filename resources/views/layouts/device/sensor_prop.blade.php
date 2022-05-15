<table>
    <tbody>
    <tr>
        <td>Add soil</td>
    </tr>
    <tr>
        <td><input type="radio" name="aggregation_logic{{$prop->getId()}}" checked value="Or"> Or </td>
        <td><input type="radio" name="aggregation_logic{{$prop->getId()}}" value="And"> And</td>
    </tr>
    <tr>
        <td class="sensor_type">{{$sensor->getType()}}</td>
        <td>
            <select name="operator">
                @foreach($operators as $operator)
                    <option value="{{$operator}}" {{$operator == $prop->getOperator() ? "selected" : ""}}>{{$operator}}</option>
                @endforeach
            </select>
        </td>
        <td><input type="number" style="max-width: 100pt" name="soil_value" value="{{$prop->getSoilValue()}}"></td>
        <td>
            <button type="submit" name="request_type" value="saveSensorProperty">✔</button>
        </td>
        <td>
            <button type="submit" name="request_type" value="deleteSensorProperty">x</button>
        </td>

        <input type="hidden" name="sensor_id" value="{{$sensor->getId()}}">
        <input type="hidden" name="device_uuid" value="{{$device->uuid}}">
        <input type="hidden" name="soil_id" value="{{$prop->getId()}}">
    </tr>
    </tbody>
</table>
