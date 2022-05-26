let messages = null
setInterval(function () {
    axios.get("http://127.0.0.1:8000/user/"+window.deviceUserId+"/messages").then(value => {
        let httpMessages = value.data;
        let offset = messages == null ? httpMessages.length : httpMessages.length - messages.length;
        if (messages == null || offset !== 0) {
            messages = httpMessages
            for (let i = httpMessages.length - offset; i < httpMessages.length; i++)
                document.getElementById("body").innerHTML += httpMessages[i]["content"] + "<br>";
        }
    })
}, 2000)
