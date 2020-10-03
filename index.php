<?php
if (!empty($_REQUEST["accion"])) {
    switch ($_REQUEST["accion"]) {
        case "GUARDAR":
            $resultadotxt = "";
            $resultadotxt =   procesar($_REQUEST);

            break;
        default:
            echo "No se pudo determinar la acción";
    }
}
function procesar($valores)
{
    //miPrint::dd($valores, "resuldos");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>prueba de webrtc</title>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>
        window.jQuery || document.write('<script src="../js/jquery-3.3.1.min.js"><\/script>')
    </script>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        $(function() {
            $("#btnGuardar").on("click", function(e) {
                e.preventDefault();
                var form = $('#formDet');
                var url = location.protocol + '//' + location.host + location.pathname + "?accion=GUARDAR";
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: form.serialize(),
                    success: function(data) {
                        alert(data);
                    }
                });
            });
        })
    </script>
</head>

<body>
    <div class="container">
        <h2>Inicio de pruebas</h2>
        <hr>
        <div class="card card-body bg-light" style="padding: 10px;">
            <ul class="list-group">
            <a href="/chat" class="list-group-item">Chat</a>
                <a class="list-group-item" href="/webcam">Simple webcam</a>
            </ul>
            
            
        </div>
    </div>
</body>

</html>