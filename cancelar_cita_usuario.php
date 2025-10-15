<?php
include 'conexion_bd.php';
session_start();
//Solo se pueden cancelar citas con NIF_mec = null
//Visualizar citas usuario con nif_mec = null
$nif_usu = $_SESSION['nif_usuario'];
$opciones_citas_a_cancelar = "";


function mostrar_error($mensaje) {
    echo "<script language='JavaScript' type='text/javascript'>
        alert('$mensaje');
    </script>";
}




function pintar_formulario_cita_cancelar($opciones_citas_a_cancelar, $nif_usu){
    
    $form = <<<FORMULARIO
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cancelar Cita</title>
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
        <form action="cancelar_cita_usuario.php" method="post">
            <h1>Registro de cita</h1>
            
            <p>
                NIF_usuario: 
                <input name="nif_usuario" type="text" maxlength="9" value="$nif_usu" disabled>
            </p>
            
            <p>
                Selecciona los tipos de Cita a cancelar: <br>
                <select name="cod_cita">
                
                $opciones_citas_a_cancelar
            
                </select>
            </p>
            
            <p>
                <input type="submit" name="submit" value="Cancelar Cita">
            </p>
        </form>
    </body>
    </html>
FORMULARIO;

    print $form;
    
}


if(empty($_POST)){
    
    $query_citas_usuario_sin_mec = "SELECT cita.* FROM cita JOIN vehiculo ON cita.matricula = vehiculo.matricula WHERE vehiculo.nif_usu = '$nif_usu' AND cita.nif_mec IS NULL";
    $res = mysqli_query($conex, $query_citas_usuario_sin_mec);
         
         while ($fila = mysqli_fetch_array($res)){
             
             $opciones_citas_a_cancelar .= "<option value='{$fila['cod_cita']}'>({$fila['matricula']})-(Fecha:{$fila['fecha_cita']})-(Hora: {$fila['hora_cita']})</option>";
             
         }
        
        
        if (mysqli_connect_errno()) {
            echo "Error en la conexión a la base de datos.";
            exit();
        }
    
        pintar_formulario_cita_cancelar($opciones_citas_a_cancelar, $nif_usu);
    
}else{
    
    $cod_cita_a_cancelar = $_POST['cod_cita'];
    
    
    
    $query_cancelar = "DELETE FROM cita WHERE cod_cita = '$cod_cita_a_cancelar'";
               
        
        $res_cancelar = mysqli_query($conex, $query_cancelar) or die (mysqli_errno($conex));
        if($res_cancelar){
           
             header("location:menuUsuario.php");       
        }else{
            
            mostrar_error("Error ");
            
            
        }
    
    
}



