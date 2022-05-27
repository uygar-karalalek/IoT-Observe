<script>
    setInterval(function () {
        axios.get("http://localhost:8081/api/fetchAllSensors/user/{{\Illuminate\Support\Facades\Auth::user()->id}}/device/{{isset($i) ? $devices[$i]->name : $device->name}}?secret=THIS_IS_A_SECRET",
            {
                headers: {
                    'Access-Control-Allow-Origin': '*',
                    'Content-Type': 'application/json',
                    'Access-Control-Allow-Methods': 'GET,PUT,POST,DELETE,PATCH,OPTIONS',
                }
            })
            .then(sensors => {
                    let httpData = sensors.data;
                    axios.post("http://127.0.0.1:8000/process/{{isset($i) ? $devices[$i]->uuid : $device->uuid}}/sensors", httpData, {
                        headers: {
                            'Access-Control-Allow-Origin': '*',
                            'Content-Type': 'application/json',
                            'Access-Control-Allow-Methods': 'GET,PUT,POST,DELETE,PATCH,OPTIONS',
                        }
                    })
                }
            );
    }, 1000)
</script>
