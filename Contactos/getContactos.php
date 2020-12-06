<?php
//SOLO ES PARA REALIZAR PRUEBAS
//Mostrar lista de contacto
//TAMBIEN ESTA IMPLEMENTADO EN REGISTRAR.PHP PARA BUSCAR LOS CONTACTOS DE UN USUARIO
$response = array();

$Cn = mysqli_connect("localhost","root","","servicios_web")or die ("server no encontrado");
mysqli_set_charset($Cn,"utf8");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $result = mysqli_query($Cn,"SELECT id_contacto,CorreoUser,CorreoC,NombreC,CelularC,TelefonoC,DomicilioC,LongitudC,LatitudC,FechaNac FROM contacto ORDER BY NombreC");
    
    if (!empty($result)) {
        if (mysqli_num_rows($result) > 0) {
            while ($res = mysqli_fetch_array($result)){
                $contacto = array();
                $contacto["success"] = 200;  
                $contacto["message"] = "contactos encontrados";
                $contacto["id_contacto"] = $res["id_contacto"];
                $contacto["CorreoUser"] = $res["CorreoUser"];
                $contacto["CorreoC"] = $res["CorreoC"];
                $contacto["NombreC"]=$res["NombreC"];
                $contacto["CelularC"]=$res["CelularC"];
                $contacto["TelefonoC"]=$res["TelefonoC"];
                $contacto["DomicilioC"]=$res["DomicilioC"];
                $contacto["LongitudC"]=$res["LongitudC"];
                $contacto["LatitudC"]=$res["LatitudC"];
                $contacto["FechaNac"]=$res["FechaNac"];

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
