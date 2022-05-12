@if(count($relatedSensors) == 0)
    NO SENSOR FOUND
@else
    @foreach($relatedSensors as $sensor)

    @endforeach
@endif
<br>
<br>
<form action="#" method="post" name="addSensor">
    <input type="hidden" name="device_uuid" value="{{$device->uuid}}">
    <input type="hidden" name="device" value="{{$device}}">
    <input type="submit">
</form>
