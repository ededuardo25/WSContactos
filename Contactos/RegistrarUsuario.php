<?php
/*
 * El siguiente código localiza un usuario
 * AGZ    Abril/2020
 */
$response = array();
$Cn = mysqli_connect("localhost","root","","servicios_web")or die ("server no encontrado");
mysqli_set_charset($Cn,"utf8");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $objArray = json_decode(file_get_contents("php://input"),true);

    if (empty($objArray)) // SI el arreglo esta vacio, mandara un mensaje error
    {
     $contacto = array();
     $contacto["success"] = 400;
     $contacto["message"] = "Faltan Datos entrada";
     array_push($response, $contacto);
    }    //(empty($objArray))  Error 400
    
    else{  //Me va a vuscar los datos que yo le pida 

        $CorreoUsr=$objArray['CorreoUsr'];
        $Contrasena=$objArray['Contrasena'];
        $Nombre=$objArray['Nombre'];
        $res = mysqli_query($Cn,"SELECT CorreoUsr,Contrasena,Nombre from usuario WHERE CorreoUsr = '$CorreoUsr'");
        if (!empty($res)) {
            if (mysqli_num_rows($res) > 0) {
                $tuplas = mysqli_fetch_array($res);
                if($Contrasena == $tuplas["Contrasena"]){
                 $result = mysqli_query($Cn,"SELECT id_contacto,CorreoUser,CorreoC,NombreC,CelularC,TelefonoC,DomicilioC,LongitudC,LatitudC,FechaNac FROM contacto WHERE CorreoUser='$CorreoUsr'");
                 if (mysqli_num_rows($result) > 0) {
                    while ($registro = mysqli_fetch_array($result)) {
                        $contacto = array();
                        $contacto["success"] = 200;  
                        $contacto["message"] = "Ya esta registrado , aqui estan los contactos";
                        $contacto["id_contacto"] = $registro['id_contacto'];
                        $contacto["CorreoUser"] = $registro['CorreoUser'];
                        $contacto["CorreoC"] = $registro['CorreoC'];
                        $contacto["NombreC"]=$registro['NombreC'];
                        $contacto["CelularC"]=$registro['CelularC'];
                        $contacto["TelefonoC"]=$registro['TelefonoC'];
                        $contacto["DomicilioC"]=$registro['DomicilioC'];
                        $contacto["LongitudC"]=$registro['LongitudC'];
                        $contacto["LatitudC"]=$registro['LatitudC'];
                        $contacto["FechaNac"]=$registro['FechaNac'];

                        array_push($response, $contacto);
                    }
                }

            //($contacto == $result["CorreoUsr"])
                else{
                    $contacto = array();
                    $contacto["success"] = 200;  
                    $contacto["message"] = "Ya esta registrado , pero no tiene contactos";
                    $contacto["id_contacto"] = "";
                    $contacto["CorreoUser"] = "";
                    $contacto["CorreoC"] = "";
                    $contacto["NombreC"]="";
                    $contacto["CelularC"]="";
                    $contacto["TelefonoC"]="";
                    $contacto["DomicilioC"]="";
                    $contacto["LongitudC"]="";
                    $contacto["LatitudC"]="";
                    $contacto["FechaNac"]="";               

                    array_push($response, $contacto);
                }
        }//(mysqli_num_rows($result)
        else{
            $contacto = array();
            $contacto["success"] = 404;
            $contacto["message"] = "El correo ya esta registrado pero la contraseña no es correcta";
            array_push($response, $contacto);
        }//Error 404

    }//(!empty($result))
    else{
       $result = mysqli_query($Cn,"INSERT INTO usuario (CorreoUsr,Contrasena,Nombre) values ('$CorreoUsr','$Contrasena','$Nombre')");
       if($result){
        $contacto= array();
        $contacto["success"] = "200";
        $contacto["message"] = "Registro exitoso";

        $contacto["id_contacto"] = "";
        $contacto["CorreoUser"] = "";
        $contacto["CorreoC"] = "";
        $contacto["NombreC"]="";
        $contacto["CelularC"]="";
        $contacto["TelefonoC"]="";
        $contacto["DomicilioC"]="";
        $contacto["LongitudC"]="";
        $contacto["LatitudC"]="";
        $contacto["FechaNac"]="";
        array_push($response,$contacto);
    }
    else{
        $contacto["success"] = 404;
        $contacto["message"] = "Error no se registro el usuario";
        array_push($response,$contacto);
    }
}
}
else{
    $result = mysqli_query($Cn,"INSERT INTO usuario (CorreoUsr,Contrasena,Nombre) values ('$CorreoUsr','$Contrasena','$Nombre')");
    if($result){
        $contacto= array();
        $contacto["success"]="200";
        $contacto["message"]="Registro exitoso";

        $contacto["CorreoUser"] = "";
        $contacto["CorreoC"] = "";
        $contacto["NombreC"]="";
        $contacto["CelularC"]="";
        $contacto["TelefonoC"]="";
        $contacto["DomicilioC"]="";
        $contacto["LongitudC"]="";
        $contacto["LatitudC"]="";
        $contacto["FechaNac"]="";
        array_push($response,$contacto);
    }
    else{
        $contacto = array();
        $contacto["success"] = 400;
        $contacto["message"] = "Error no se registro el usuario";
        array_push($response,$usuario);
    }
}
}
}
else{
    $contacto = array();
    $contacto["success"] = 400;
    $contacto["message"] = "Error no se registro usuario";
    array_push($response,$contacto);
}
echo json_encode($response);
mysqli_close($Cn);
?>