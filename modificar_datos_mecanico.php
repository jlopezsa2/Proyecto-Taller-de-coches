<?php

 include 'conexion_bd.php';

$NIF_mec = "";
$nombre_mec = "";        
$apellidos_mec = "";

$opciones_mecanicos = "";


function mostrar_error($mensaje) {
    echo "<script language='JavaScript' type='text/javascript'>
        alert('$mensaje');
    </script>";
}

function pintar_formulario_modificar_mecanico($opciones_mecanicos) {
    $form = <<<FORMULARIO
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registro de Vehículo</title>
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

            input[type="text"], input[type="number"], input[type="submit"] {
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
        <form action="modificar_datos_mecanico.php" method="post">
            <h1>Modificar datos mecanico</h1>
            
            <p>
           Mecanico a modificar:
            <select name="nif_mec_opc">
            $opciones_mecanicos
            </select>
        </p>
        
         <p>
            NIF_mec:
            <input name="nif_mec" type="text" maxlength="50" required id="nif_mec">
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
        </form>
    </body>
    </html>
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

if (empty($_POST)) {
    
    
    
    $query_mecanicos = "SELECT nif_mec, nombre, apellidos FROM mecanico WHERE 1=1";
    $res = mysqli_query($conex, $query_mecanicos);
         
         while ($fila = mysqli_fetch_array($res)){
             
             $opciones_mecanicos .= "<option value='{$fila['nif_mec']}'>{$fila['nombre']} {$fila['apellidos']}</option>";
             
         }
        
        
        if (mysqli_connect_errno()) {
            echo "Error en la conexión a la base de datos.";
            exit();
        }
    
   
        pintar_formulario_modificar_mecanico($opciones_mecanicos);
    
    }else {
        
        $NIF_mec_modificar = $_POST['nif_mec_opc'];
        $NIF_mec = $_POST['nif_mec'];
        $nombre_mec = $_POST['nombre_mec'];
        $apellidos_mec = $_POST['apellidos_mec'];
        
    
    if (validar_datos($NIF_mec, $nombre_mec, $apellidos_mec)) {
        

            $query = "UPDATE mecanico SET nif_mec='$NIF_mec', nombre= '$nombre_mec', apellidos='$apellidos_mec' WHERE nif_mec='$NIF_mec_modificar'";
            $res = mysqli_query($conex, $query) or die (mysqli_errno($conex));

            if ($res) {
                header("Location: menuAdmin.php"); // Redirigir después de guardar
                //exit();
                
            } else {
                
                mostrar_error("No se ha modificado error");
                $query_mecanicos = "SELECT nif_mec, nombre, apellidos FROM mecanico WHERE 1=1";
            $res = mysqli_query($conex, $query_mecanicos);
         
         while ($fila = mysqli_fetch_array($res)){
             
             $opciones_tipos_cita .= "<option value='{$fila['nif_mec']}'>{$fila['nombre']} {$fila['apellidos']}</option>";
             
         }
        
        
        if (mysqli_connect_errno()) {
            echo "Error en la conexión a la base de datos.";
            exit();
        }
                pintar_formulario_modificar_mecanico($opciones_mecanicos);
                
            }
         
        
        
    } else {
        mostrar_error("Algo salio mal");
        pintar_formulario_modificar_mecanico($opciones_mecanicos);
    }

    }

?>

