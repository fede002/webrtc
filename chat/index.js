navigator.webkitGetUserMedia(
  {
    video: true,
    audio: true
  },
  function (stream) {
    const p = new SimplePeer({
      initiator: location.hash === "#init",
      trickle: false,
      stream: stream
    });

    //window.onload = function () {
      p.on("error", err => console.log("error", err));

      p.on("signal", data => {
        //console.log("SIGNAL", JSON.stringify(data));
        document.querySelector("#idPrincipal").value = JSON.stringify(data);
      });

      document
        .getElementById("btnConectar")
        .addEventListener("click", function () {
          var otherID = JSON.parse(
            document.getElementById("idSecundario").value
          );
          p.signal(otherID);
        });

      document
        .getElementById("btnEnviar")
        .addEventListener("click", function () {
          var mensaje = document.getElementById("tuMensaje").value;
          p.send(mensaje);
        });

      p.on("data", function (data) {
        document.getElementById("mensajes").textContent += data + "\n";
      });

      p.on("stream", function (stream) {
        var video = document.createElement("video");
        document.body.appendChild(video);
        //fix en chrome 71
        //video.src = window.URL.createObjectURL(stream);
        video.srcObject = stream
        video.play();
      });
    //};
  },
  function (err) {
    console.log("Error general");
    console.error(err);
  }
);
