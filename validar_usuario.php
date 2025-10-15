<?php
    session_start();
    include 'conexion_bd.php';
    
    $nif_usuario = $_POST['nif_usuario'];
    $clave = $_POST['clave'];
    $nombre_usuario = "";
    $apellidos = "";
    
    
   $query = "SELECT nif_usu, nombre, apellidos FROM usuario "
            . "WHERE (nif_usu LIKE '$nif_usuario') AND (clave LIKE '$clave')";
    
        $res_valid = mysqli_query($conex, $query) or die (mysqli_error($conex));
    
    
        if ((mysqli_num_rows($res_valid) == 1)){
            $_SESSION['nif_usuario'] = $nif_usuario;
            $_SESSION['clave'] = $clave;
            
            
            
            
            while ($fila = mysqli_fetch_array($res_valid)){
             
             $nombre_usuario = $fila['nombre'];
             $apellidos = $fila['apellidos'];        
            }
            
            $_SESSION['apellidos'] = $apellidos;
            $_SESSION['nombre_usuario'] = $nombre_usuario;
                        
             header("location:menuUsuario.php");       
         
             
        } else {
            
            header("location:loginUser.php");
                  
        }
    