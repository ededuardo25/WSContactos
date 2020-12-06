<?php
//ELMINA UN CONTACTO DE LA TABLA CONTACTO
$response = array();

$Cn = mysqli_connect("localhost","root","","servicios_Web")or die ("server no encontrado");
mysqli_set_charset($Cn,"utf8");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $objArray = json_decode(file_get_contents("php://input"),true);
    if (empty($objArray))
    {
        // required field is missing
        $response["success"] = 400;
        $response["message"] = "Faltan Datos entrada";
        echo json_encode($response);
    }
    else{
        $CelularC=$objArray['CelularC']; 
        $result = mysqli_query($Cn,"DELETE FROM contacto WHERE CelularC='$CelularC'");
        if ($result) {   
            $response["success"] = 200;   // El success=200 es que encontro eñ producto
            $response["message"] = "Alumno Eliminado";
            // codifica la información en formato de JSON response
            echo json_encode($response);
        } else {
                // 
                $response["success"] = 406;  
                $response["message"] = "El contacto no se Elimino";
                echo json_encode($response);
        }
    }
} else {
    // required field is missing
    $response["success"] = 400;
    $response["message"] = "Faltan Datos entrada";
    echo json_encode($response);
}
mysqli_close($Cn);
?>
