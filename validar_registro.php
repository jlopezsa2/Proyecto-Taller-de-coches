<?php

session_start();

$nif_usuario = $_POST['nif_usuario'];
$nombre_usuario = $_POST['nombre'];
$apellidos = $_POST['apellidos'];
$clave = $_POST['clave'];



function mostrar_error($mensaje){
?>
    <script language="JavaScript" type="text/JavaScript">
        var mensaje = "<?php echo $mensaje; ?>";
        alert(mensaje);
    
    </script>
<?php
}



function validar_datos($nif_usuario, $nombre_usuario, $apellidos, $clave){
    
    if (($nif_usuario == "") || (!preg_match("/^[0-9]{8}[a-zA-Z]{1}/", $nif_usuario))){
        $nif_usuario = "";
        
        mostrar_error("NIF inválido");
        return false;
    }
    
    if($nombre_usuario == ""){
        mostrar_error("Nombre inválido");
        return false;
    }
   
    
    if ($apellidos == ""){
        $apellidos = "";
        mostrar_error("apellidos incorrecto");
        return false;
    }
    
    if (($clave == "")){
        mostrar_error("Falta contraseñas");
        return false;
    } 
    
    
    if (!preg_match("/^.{8,}$/", $clave)){
        $clave = "";
        
        mostrar_error("Clave tiene menos de 8 caracteres");
        return false;
    }
    
    
    
    
    return true;
}

function pintar_formulario($nif_usuario, $nombre_usuario, $apellidos, $clave){
    $fomulario1=<<<FORMULARIO1
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
            }

            /* Main Form Container */
            form {
                background-color: #fff;
                padding: 30px;
                border-radius: 8px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                width: 300px;
                box-sizing: border-box;
                text-align: center;
            }

            /* Heading Style */
            h1 {
                color: #333;
                font-size: 24px;
                margin-bottom: 20px;
                font-weight: bold;
            }

          
            input[type="text"], input[type="password"] {
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
                padding: 10px 20px;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
                width: 100%;
                transition: background-color 0.3s ease;
            }

            input[type="submit"]:hover {
                background-color: #45a049;
            }

            
            a {
                display: inline-block;
                margin-top: 10px;
                color: #4CAF50;
                text-decoration: none;
                font-size: 14px;
                transition: color 0.3s ease;
            }

            a:hover {
                color: #388e3c;
            }

            
            p {
                margin: 0;
                padding: 0;
            }
            
            
        </style>
            
            
            
            <form action="validar_registro.php" method="post">
            <h1>Registro en el sistema</h1>
            
            <p>
                NIF: 
                <input name="nif_usuario" type="text" size="9" maxlength="9" required>
            </p>
            
            <p>
                Nombre: 
                <input name="nombre" type="text" size="20" maxlength="20" required>
            </p>
            
            <p>
                Apellidos: 
                <input name="apellidos" type="text" size="20" maxlength="20" required>
            </p>
            
            <p>
                Contraseña: 
                <input name="clave" type="password" maxlength="20" required>
            </p>
            
            <p>
                <input type="submit" name="submit" value="Guardar">
            </p>

            
            <p>
                <a href="loginUser.php">Iniciar sesión</a>
            </p>

            <p>
                <a href="registroAdmin.php">Soy administrador</a>
            </p>
            
        </form>
            

            
FORMULARIO1;
    print $fomulario1;
}


if (!validar_datos($nif_usuario, $nombre_usuario, $apellidos, $clave)){
    pintar_formulario($nif_usuario, $nombre_usuario, $apellidos, $clave);
    
} else {
    $conex = mysqli_connect('localhost', 'root', '') or die (mysqli_errno($conex));
    mysqli_select_db($conex, "trabajosw") or die (mysqli_errno($conex));
    
    if (mysqli_errno($conex)){
        echo("Error en la conexión");
        exit();
    } else {
        
        
        
        $query2 = "SELECT nif_usu FROM usuario "
            . "WHERE nif_usu = '$nif_usuario'";
    
        $res_valid2 = mysqli_query($conex, $query2) or die (mysqli_error($conex));
    
    
        if ((mysqli_num_rows($res_valid2) == 0)){
       
            
            
            $query = "INSERT INTO usuario (nif_usu, nombre, apellidos, clave) "
                . "VALUES ('$nif_usuario', '$nombre_usuario', '$apellidos', '$clave')";
        
        $res = mysqli_query($conex, $query) or die (mysqli_errno($conex));
        if($res){
            $_SESSION['nif_usuario'] = $nif_usuario;
            $_SESSION['nombre_usuario'] = $nombre_usuario;
            $_SESSION['apellidos'] = $apellidos;
            $_SESSION['clave'] = $clave;
            
             header("location:menuUsuario.php");       
        }
            
            
             
        }else{
            mostrar_error("Ya existe un usuario con ese dni");
            pintar_formulario($nif_usuario, $nombre_usuario, $apellidos, $clave);
            
        }
        
        
         
        
    }
    
    
}




