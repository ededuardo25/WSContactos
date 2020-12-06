<?php
//AGREGA UN USUARIO A LA TABLA USUARIO 
//Este en realidad no se usa, ya esta implementado en el archivo RegistrarUsuario.php
//Lo tengo solo para pruebas

$response = array();
$usuario = array();

$Cn = mysqli_connect("localhost","root","","servicios_web")or die ("server no encontrado");
mysqli_set_charset($Cn,"utf8");

// Checa que le este llegando por el método POST el nomProd,existencia y precio

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $objArray = json_decode(file_get_contents("php://input"),true);
    if (empty($objArray))
    {
        // required field is missing
        $usuario["success"] = 400;
        $usuario["message"] = "Faltan Datos entrada";
        array_push($response,$usuario);
        echo json_encode($response);
    }
    else{
        $CorreoUsr=$objArray['CorreoUsr']; 
        $Contrasena=$objArray['Contrasena'];
        $Nombre=$objArray['Nombre'];


        $result = mysqli_query($Cn,"INSERT INTO usuario (CorreoUsr,Contrasena,Nombre) values 
        ('$CorreoUsr','$Contrasena','$Nombre')");

        //$idprod = mysqli_insert_id($Cn);
        if ($result) {   
            $usuario["success"] = 200;   // El success=200 es que encontro eñ usuario
            $usuario["message"] = "usuario Insertado";

            array_push($response,$usuario);
            echo json_encode($response);
        } else {
                // 
                $usuario["success"] = 406;  
                $usuario["message"] = "usuario no Insertado";
                array_push($response,$usuario);
                echo json_encode($response);
        }
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