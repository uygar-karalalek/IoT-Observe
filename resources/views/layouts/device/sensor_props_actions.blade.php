<td>Sensor type:</td>
<td>
    <select id="sensor_type" name="sensor_type" onchange="changeTheUnit(this)">
    </select>
    @include("script.device_sensor_props_action_react")
</td>
<td>
    <button type="submit" name="request_type" value="saveSensor">Ok</button>
</td>
<td>
    <button type="submit" name="request_type" value="removeSensor"> x</button>
</td>
