<?php

use App\Helpers\miPrint;

include_once("miPrint.php");

if (!empty($_REQUEST["accion"])) {
    switch ($_REQUEST["accion"]) {
        case "GUARDAR":
            guardar($_REQUEST);
            break;
        case "LISTAR":
            listar($_REQUEST);
            break;
        case "BORRAR":
            borrar($_REQUEST);
            break;
        default:
            var_dump($_REQUEST);
            echo "No se pudo determinar la acción";
            die();
    }
}

function configDb()
{
    return  [
        "server" => "localhost",
        "user" => "id14916588_chat_usu",
        "password" => "Federico123$",
        "db" => "id14916588_chat_db",
    ];
}

function guardar($valores)
{
    $sql = "INSERT INTO chats (CHA_KEY, CHA_TIPO) VALUES ('" . $valores["idPrincipal"] . "','" . $valores["obs"] . "')";

    $conf = configDb();
    $resul =  miPrint::queryExecMysql($sql, $conf["server"], $conf["user"], $conf["password"], $conf["db"]);
    $resul = ["status" => "ok", "msg" => "Se guardo la key"];
    header('Content-Type: application/json');
    echo json_encode($resul);
    exit;
}
function borrar($valores)
{
    $sql = "DELETE FROM chats WHERE CHA_ID = " . $valores["CHA_ID"] . "";

    $conf = configDb();
    $resul =  miPrint::queryExecMysql($sql, $conf["server"], $conf["user"], $conf["password"], $conf["db"]);
    $resul = ["status" => "ok", "msg" => "Se guardo la key"];
    header('Content-Type: application/json');
    echo json_encode($resul);
    exit;
}
function listar()
{
    $sql = "SELECT * FROM  chats ";

    $conf = configDb();
    $resultados =  miPrint::queryMysql($sql, $conf["server"], $conf["user"], $conf["password"], $conf["db"]);
    $resul = ["status" => "ok", "msg" => $resultados];
    header('Content-Type: application/json');
    echo json_encode($resul);
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
        function listar(data) {
            //console.log("entroooooo") 
            $("#table1 thead").empty()
            $("#table1 tbody").empty()
            const thead = $("#table1 thead");
            const tbody = $("#table1 tbody");
            let tr = $("<tr />");
            console.log(data)
            if (data.length > 0) {
                $.each(Object.keys(data[0]), function(_, key) {
                    //console.log(key)
                    tr.append("<th>" + key + "</th>")
                });
                tr.append("<th>Opciones</th>")
                tr.appendTo(thead);
                $.each(data, function(_, obj) {
                    tr = $("<tr />");
                    //console.log(obj)
                    $.each(obj, function(_orden, text) {
                        //console.log(_orden)
                        //console.log(text)
                        if (_orden == "CHA_KEY") {
                            tr.append("<td><input class='form-control' type='text' value='" + text + "'/></td>")
                        } else {
                            tr.append("<td>" + text + "</td>")
                        }
                    });
                    tr.append("<td><button type='button' class='btn btn-info btn-sm btnBorrar' data-id='" + obj.CHA_ID + "' >Borrar</button></td>")
                    tr.appendTo(tbody);
                });
            }
        }

        $(function() {

            function cargarListados() {
                var form = $('#formDet');
                var url = location.protocol + '//' + location.host + location.pathname + "?accion=LISTAR";
                $.ajax({
                    type: 'POST',
                    url: url,
                    success: function(datos) {
                        console.log("success")
                        //console.log(datos)
                        if (datos.status == "ok") {
                            //console.log("estatus ok")
                            listar(datos.msg);
                        } else {
                            console.log("estado es distincto de ok")
                        }
                    }
                });
            }

            cargarListados();

            $("#btnGuardar").on("click", function(e) {
                e.preventDefault();
                var form = $('#formDet');
                var url = location.protocol + '//' + location.host + location.pathname + "?accion=GUARDAR";
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: form.serialize(),
                    success: function(data) {
                        if (data.status == "ok") {
                            cargarListados();
                        }
                    }
                });
            });

            $("#btnRefrescar").on("click", function(e) {
                cargarListados();
            });

            $("#formDet").on("click", ".btnBorrar", function(e) {
                e.preventDefault();
                var form = $('#formDet');
                var cha_id = $(this).data("id");
                var url = location.protocol + '//' + location.host + location.pathname + "?accion=BORRAR&CHA_ID=" + cha_id;
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: form.serialize(),
                    success: function(data) {
                        if (data.status == "ok") {
                            cargarListados();
                        }
                    }
                });
            })

        })
    </script>
    <script src="node_modules/simple-peer/simplepeer.min.js"></script>
    <script src="index.js"></script>
</head>

<body>
    <form class="container" id="formDet">
        <div class="card">
            <div class="card-header">
                Form en php
            </div>
            <div class="card-body">
                <a href="/chat/#init">Link para host</a>
                <a href="/chat">Link para cliente</a>
                <hr>
                <label for="" class="label">Id principal:</label>
                <input type="text" class="form-control" id="idPrincipal" name="idPrincipal" />
                <label for="">Id secundario</label>
                <input type="text" class="form-control" id="idSecundario" name="idSecundario" />
                <label for="" class="label">Tipo:</label>
                <input type="text" class="form-control" id="obs" name="obs">
            </div>
        </div>
        <dic class="card">
            <div class="card-body">
                <div class="float-left">
                    <button type="button" id="btnConectar" class="btn btn-info">conectar</button>
                </div>
                <div class="float-right">
                    <button type="button" id="btnGuardar" class="btn btn-info">Guardar form</button>
                    <button type="button" id="btnRefrescar" class="btn btn-info">Recargar listado</button>
                </div>
            </div>
        </dic>
        <div>
            <h3>Llamadas cargadas</h3>
            <hr>
            <table id="table1" class="table table-bordered table-sm">
                <thead>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <hr>

        <label for="">Mensaes:</label>
        <input type="text" id="tuMensaje">
        <button type="button" class="btn btn-success" id="btnEnviar">Enviar</button>
        <pre id="mensajes"></pre>
        <hr>
    </form>
</body>

</html>