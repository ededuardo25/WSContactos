<?php
//Se editara un usuario
//En el Query se usa de referencia el Celular
//LA BUSQUEDA DEL USUARIO YA ESTA IMPLEMENTADO EN REGISTRARUSUARIO.PHP
	//PARA VERIFICAR SI EL USUARIO EXISTE

$response = array();
$producto = array();

$Cn = mysqli_connect("localhost","root","","servicios_web")or die ("server no encontrado");
mysqli_set_charset($Cn,"utf8");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $objArray = json_decode(file_get_contents("php://input"),true);
    if (empty($objArray))
    {
        // required field is missing
        $producto["success"] = 400;
        $producto["message"] = "Faltan Datos entrada";
        array_push($response,$producto);
        echo json_encode($response);
    }
    else{
  
        $id_contacto=$objArray['id_contacto'];
        $CorreoC=$objArray['CorreoC']; 
        $NombreC=$objArray['NombreC'];
        $CelularC=$objArray['CelularC'];
        $TelefonoC=$objArray['TelefonoC'];
        $DomicilioC=$objArray['DomicilioC'];
        $LongitudC=$objArray['LongitudC'];
        $LatitudC=$objArray['LatitudC'];
        $result = mysqli_query($Cn,"UPDATE contacto SET CorreoC='$CorreoC',NombreC='$NombreC',CelularC=$CelularC,TelefonoC='$TelefonoC',DomicilioC='$DomicilioC',LongitudC='$LongitudC',LatitudC='$LatitudC' WHERE id_contacto=$id_contacto");
        if ($result) {   
            $producto["success"] = 200;   // El success=200 es que encontro eñ producto
            $producto["message"] = "Producto Actualizado";
            array_push($response,$producto);
            echo json_encode($response);
        } else {
                $producto["success"] = 406;  
                $producto["message"] = "El Producto no se actualizo";
                array_push($response,$producto);
                echo json_encode($response);
        }
    }
} else {
    // required field is missing
    $producto["success"] = 400;
    $producto["message"] = "Faltan Datos entrada";
    array_push($response,$producto);
    echo json_encode($response);
}
mysqli_close($Cn);
?>
