<?php
//SOLO ES PARA PRUEBAS
//Muestra un contacto en especifico

$response = array();
$usuario = array();
$Cn = mysqli_connect("localhost","root","","servicios_web")or die ("server no encontrado");
mysqli_set_charset($Cn,"utf8");

// Checa que le este llegando por el método POST el idProd

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $objArray = json_decode(file_get_contents("php://input"),true);
    
    $CorreoUsr=$objArray['CorreoUsr'];
    $result = mysqli_query($Cn,"SELECT CorreoUsr,Contrasena,Nombre from Usuario WHERE CorreoUsr = '$CorreoUsr'");

    if (!empty($result)) {
        if (mysqli_num_rows($result) > 0) {

            $result = mysqli_fetch_array($result);
            $usuario["success"] = 200;   // El success=200 es que encontro el usuario
            $usuario["message"] = "usuario encontrado";
            $usuario["CorreoUsr"] = $result["CorreoUsr"];
            $usuario["Contrasena"] = $result["Contrasena"];
            $usuario["Nombre"] = $result["Nombre"];
            array_push($response,$usuario);

           // codifica la información en formato de JSON response
           echo json_encode($response);
        } else {
            // No Encontro el usuario
            $usuario["success"] = 404;  //No encontro información y el success = 0 indica no exitoso
            $usuario["message"] = "usuario no encontrado";
            array_push($response,$usuario);
            echo json_encode($response);
        }
    } else {
        $usuario["success"] = 404;  //No encontro información y el success = 0 indica no exitoso
        $usuario["message"] = "usuario no encontrado";
        array_push($response,$usuario);
        echo json_encode($response);
    }
} else {
    // required field is missing
    $usuario["success"] = 400;
    $usuario["message"] = "Faltan Datos entrada";
    array_push($response,$usuario);
    echo json_encode($response);
}
mysqli_close($Cn);
?>