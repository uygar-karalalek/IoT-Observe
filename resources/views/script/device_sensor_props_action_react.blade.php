<script>
    let previous = null;
    setInterval(function () {
        axios.get("http://localhost:8081/api/fetchAllSensors/user/{{\Illuminate\Support\Facades\Auth::user()->id}}/device/{{$device->name}}?secret=THIS_IS_A_SECRET").then(value => {
            let data = value.data;
            if (previous == null || previous.length !== data.length) {
                previous = data;
                data.forEach(element => {
                    document.getElementById("sensor_type").innerHTML += "<option name='" + element["type"] + "' value='" + element["type"] + "'>" + element["type"] + "</option>";
                })
            }
        })
    }, 1000)
</script>
