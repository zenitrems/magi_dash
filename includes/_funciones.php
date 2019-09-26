<?php
include_once("_db.php");
switch ($_POST["accion"]) {
    case 'login':
        login();
        break;
    case 'consultar_data':
        consultar_data();
        break;
    case 'kill_session':
        kill_session();
        break;
    default:
        break;
}
function login()
{
    global $mysqli;
    $usr = $_POST["usr"];
    $pass = $_POST["password"];
    if (empty($mail) && empty($pass)) {
        //empty boxes
        echo "2";
    } else {
        $query = "SELECT * FROM dash_usr WHERE usr_usr = '$usr'";
        $res = $mysqli->query($query);
        $row = $res->fetch_assoc();
        if ($row == 0) {
            //Correo no existe
            echo "0";
        } else {
            $query = "SELECT * FROM dash_usr WHERE usr_usr = '$usr' AND usr_pass = '$pass'";
            $res = $mysqli->query($query);
            $row = mysqli_fetch_array($res);
            //Si el password no es correcto, imprimir 0
            if ($row["usr_pass"] != $pass) {
                echo "0";
                //Si el usuario es correcto, imprimir 1
            } elseif ($usr == $row["usr_usr"] && $pass == $row["usr_pass"]) {
                echo "1";
                session_start();
                error_reporting(0);
                $_SESSION['auth'] = $usr;
            }
        }
    }
}
function consultar_data()
{
    global $mysqli;
    $query = "SELECT * FROM dash_data";
    $res = mysqli_query($mysqli, $query);
    $arreglo = [];
    while ($fila = mysqli_fetch_array($res)) {
        array_push($arreglo, $fila);
    }
    echo json_encode($arreglo); //Imprime el JSON ENCODEADO
}

function kill_session()
{
    session_start();
    error_reporting(0);
    session_destroy();
    echo "index.html";
}
