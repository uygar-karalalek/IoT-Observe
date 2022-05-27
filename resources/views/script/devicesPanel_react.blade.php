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
            Array.from(document.getElementsByClassName("text-device-connection")).forEach(option => {
                let present = false;
                value.data.forEach(device => {
                    if (option.getAttribute("id").includes("text" + device.name)) present = true;
                });
                if (present) option.innerHTML = "<span style='color: #7bba3b;'><u>Status: Connected</u></span>";
                else option.innerHTML = "<span style='color: #e7a1a1'><u>Status: Not connected</u></span>";
            });

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
                            if (document.getElementById("option" + device.name) == null)
                                document.getElementById("deviceName").innerHTML += "<option id='option" + device.name + "' value='" + device.name + "'>" + device.name + "</option>"
                        })
                        fillDeviceType()
                    }
                })
            }
        })
    }, 1000)
</script>
