<?php
//SOLO ES PARA REALIZAR PRUEBAS
//Me muestra la lista de contacto

$response = array();

$Cn = mysqli_connect("localhost","root","","servicios_web")or die ("server no encontrado");
mysqli_set_charset($Cn,"utf8");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $result = mysqli_query($Cn,"SELECT CorreoUsr,Contrasena,Nombre FROM usuario ORDER BY Nombre");
    
    if (!empty($result)) {
        if (mysqli_num_rows($result) > 0) {
            while ($res = mysqli_fetch_array($result)){
                $contacto = array();
                $contacto["success"] = 200;  
                $contacto["message"] = "contactos encontrados";
                
                $contacto["CorreoUsr"] = $res["CorreoUsr"];
                $contacto["Contrasena"] = $res["Contrasena"];
                $contacto["Nombre"] = $res["Nombre"];

                array_push($response, $contacto);
            }
           echo json_encode($response);
        } else {
            $contacto = array();
            $contacto["success"] = 404;  //No encontro información y el success = 0 indica no exitoso
            $contacto["message"] = "contacto no encontrado";
            array_push($response, $contacto);
            echo json_encode($response);
        }
    } else {
        $contacto = array();
        $contacto["success"] = 404;  //No encontro información y el success = 0 indica no exitoso
        $contacto["message"] = "contacto no encontrado";
        array_push($response, $contacto);
        echo json_encode($response);
    }
} else {
    $contacto = array();
    $contacto["success"] = 400;
    $contacto["message"] = "Faltan Datos entrada";
    array_push($response, $contacto);
    echo json_encode($response);
}
mysqli_close($Cn);
?>
