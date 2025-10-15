<?php

 include 'conexion_bd.php';

$NIF_mec = "";
$nombre_mec = "";        
$apellidos_mec = "";



function mostrar_error($mensaje){
?>
    <script language="JavaScript" type="text/JavaScript">
        var mensaje = "<?php echo $mensaje; ?>";
        alert(mensaje);
    
    </script>
<?php
}


function pintar_formulario_anadir_mecanico($NIF_mec, $nombre_mec, $apellidos_mec){
$form = <<<FORMULARIO
        <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            box-sizing: border-box;
            text-align: center;
        }

        h1 {
            color: #4CAF50;
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        input[type="text"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        input[disabled] {
            background-color: #f5f5f5;
        }

        p {
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>

    <form action="anadir_mecanico.php" method="post" id="form-mecanico">
        <h1>Registro de Mecánico</h1>
        
        <p>
            NIF Mecanico:
            <input name="nif_mec" type="text" maxlength="9" required id="nif_mec">
        </p>
        
        <p>
            Nombre:
            <input name="nombre_mec" type="text" maxlength="50" required id="nombre_mec">
        </p>
        
        <p>
            Apellidos:
            <input name="apellidos_mec" type="text" maxlength="50" required id="apellidos_mec">
        </p>
        
        <p>
            <input type="submit" name="submit" value="Guardar">
        </p>
    </form>
        
        
        
FORMULARIO;
 
print $form;
    
}


function validar_datos($NIF_mec, $nombre_mec, $apellidos_mec){
    
    if (($NIF_mec == "") || (!preg_match("/^[0-9]{8}[a-zA-Z]{1}/", $NIF_mec))){
        $nif_usuario = "";
        
        mostrar_error("NIF inválido");
        return false;
    }
    
    if($nombre_mec == ""){
        mostrar_error("Nombre inválido");
        return false;
    }
   
    
    if ($apellidos_mec == ""){
        $apellidos_mec = "";
        mostrar_error("apellidos incorrecto");
        return false;
    }
    
    
    return true;
}



if(empty($_POST)){
    
    pintar_formulario_anadir_mecanico($NIF_mec, $nombre_mec, $apellidos_mec);
    
    
    
}else{
    
    $NIF_mec = $_POST['nif_mec'];
     $nombre_mec = $_POST['nombre_mec'];
      $apellidos_mec = $_POST['apellidos_mec'];
    
    if(validar_datos($NIF_mec, $nombre_mec, $apellidos_mec)){
        
        if (mysqli_errno($conex)){
        echo("Error en la conexión");
        exit();
    } else {
        
        
        
        $query2 = "SELECT nif_mec FROM mecanico "
            . "WHERE nif_mec = '$NIF_mec'";
    
        $res_valid2 = mysqli_query($conex, $query2) or die (mysqli_error($conex));
    
    
        if ((mysqli_num_rows($res_valid2) == 0)){
       
            
            
            $query = "INSERT INTO mecanico (nif_mec, nombre, apellidos) "
                . "VALUES ('$NIF_mec', '$nombre_mec', '$apellidos_mec')";
        
        $res = mysqli_query($conex, $query) or die (mysqli_errno($conex));
        if($res){
           
             header("location:menuAdmin.php");       
        }
            
            
        }else{
            mostrar_error("Ya existe un mecanico con ese dni");
            pintar_formulario($nif_usuario, $nombre_usuario, $apellidos, $clave);
            
        }   
    }
    
    } else {
        pintar_formulario_anadir_mecanico($NIF_mec, $nombre_mec, $apellidos_mec);
    }
    
  
}
    
   





