<script>
    let devices = null;

    function fillDeviceType() {
        let deviceName = document.getElementById("deviceName").value;
        devices.forEach(device => {
            if (device.name === deviceName) {
                document.getElementById("devType").value = device.type

            }
        })
    }

    setInterval(function () {
        axios.get("http://localhost:8081/api/fetchAllDevices/{{\Illuminate\Support\Facades\Auth::user()->id}}?secret=THIS_IS_A_SECRET", {
            headers: {
                'Access-Control-Allow-Origin': '*',
                'Content-Type': 'application/json',
                'Access-Control-Allow-Methods': 'GET,PUT,POST,DELETE,PATCH,OPTIONS',
            }
        }).then(value => {
            if (devices == null || value.data.length !== devices.length) {
                document.getElementById("deviceName").innerHTML = "";
                devices = value.data;
                axios.post("http://127.0.0.1:8000/clientDevices/toProcess", devices, {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }).then(filteredDevices => {
                    if (filteredDevices.data.length === 0) {
                        document.getElementById("createDevice").disabled = true;
                    } else {
                        document.getElementById("createDevice").disabled = false;
                        filteredDevices.data.forEach(device => {
                            document.getElementById("deviceName").innerHTML += "<option value='" + device.name + "'>" + device.name + "</option>"
                        })
                        fillDeviceType()
                    }
                })
            }
        })
    }, 1000)
</script>
