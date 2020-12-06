<?php
//AgregarContacto FUNCIONA PARA AGREGAR CONTACTO A LA TABLA CONTACTO

$response = array();
$contacto = array();

$Cn = mysqli_connect("localhost","root","","servicios_web")or die ("server no encontrado");
mysqli_set_charset($Cn,"utf8");

// Checa que le este llegando por el método POST el nomProd,existencia y precio

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $objArray = json_decode(file_get_contents("php://input"),true);
    if (empty($objArray))
    {
        // required field is missing
        $contacto["success"] = 400;
        $contacto["message"] = "Faltan Datos entrada";
        array_push($response,$contacto);
        echo json_encode($response);
    }
    else{
        $CorreoUser=$objArray['CorreoUser']; 
        $CorreoC=$objArray['CorreoC'];
        $NombreC=$objArray['NombreC'];
        $CelularC=$objArray['CelularC'];
        $TelefonoC=$objArray['TelefonoC'];
        $DomicilioC=$objArray['DomicilioC'];
        $LongitudC=$objArray['LongitudC'];
        $LatitudC=$objArray['LatitudC'];
        $FechaNac=$objArray['FechaNac'];


        $result = mysqli_query($Cn,"INSERT INTO contacto(CorreoUser,CorreoC,NombreC,CelularC,TelefonoC,DomicilioC,LongitudC,LatitudC,FechaNac) values 
        ('$CorreoUser','$CorreoC','$NombreC','$CelularC','$TelefonoC','$DomicilioC','$LongitudC','$LatitudC','$FechaNac')");
        //$idprod = mysqli_insert_id($Cn);
        if ($result) {   
            $contacto["success"] = 200;   // El success=200 es que encontro eñ contacto
            $contacto["message"] = "contacto Insertado";

            array_push($response,$contacto);
            echo json_encode($response);
        } else {
                // 
                $contacto["success"] = 406;  
                $contacto["message"] = "contacto no Insertado";
                array_push($response,$contacto);
                echo json_encode($response);
        }
    }
} else {
    // required field is missing
    $contacto["success"] = 400;
    $contacto["message"] = "Faltan Datos entrada";
    array_push($response,$contacto);
    echo json_encode($response);
}
mysqli_close($Cn);
?>
