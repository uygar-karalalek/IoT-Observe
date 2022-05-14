<table>
    <tbody>
    <tr>
        <td>Add soil</td>
        <td class="sensor_type">{{$sensorTypes[0]->getUnit()}}</td>
        <td>
            <select name="operators" name="soilOperator">
                @foreach($operators as $operator)
                    <option value="{{$operator}}">{{$operator}}</option>
                @endforeach
            </select>
        </td>
        <td><input type="number" style="max-width: 100pt" name="soilValue"></td>
        <td><button type="submit" name="request_type" value="saveSensorProperty">✔</button></td>
        <td><button type="submit" name="request_type" value="deleteSensorProperty">x</button></td>
    </tr>
    </tbody>
</table>
