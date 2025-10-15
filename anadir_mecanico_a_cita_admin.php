<?php

  include 'conexion_bd.php';
session_start();
$opciones_citas = "";

$cod_cita_a_anadir_mec = "";


function mostrar_error($mensaje) {
    echo "<script language='JavaScript' type='text/javascript'>
        alert('$mensaje');
    </script>";
}


function pintar_formulario_seleccionar_cita($opciones_citas) {
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
        <form action="anadir_mecanico_a_cita_admin.php" method="post">
            <h1>Asociar mecanico a cita</h1>
            
            
            <p>
                Seleccion de cita para asociar mecanico: 
                <select name="cod_cita">
                
                $opciones_citas
            
                </select>
            </p>
                
            
            <p>
                <input type="submit" name="submit" value="Siguiente">
            </p>
        </form>
    </body>
    </html>
FORMULARIO;

    print $form;
}




if(empty($_POST)){
    
    
    
    $query_citas_sin_mecanico = "SELECT * FROM cita WHERE nif_mec IS NULL";
    $res = mysqli_query($conex, $query_citas_sin_mecanico);
         
         while ($fila = mysqli_fetch_array($res)){
             
             $opciones_citas .= "<option value='{$fila['cod_cita']}'>({$fila['matricula']})-(Fecha:{$fila['fecha_cita']})-(Hora: {$fila['hora_cita']})</option>";
             
         }
        
        
        if (mysqli_connect_errno()) {
            echo "Error en la conexión a la base de datos.";
            exit();
        }
    
        pintar_formulario_seleccionar_cita($opciones_citas);
        
  
}else{
    $cod_cita_a_anadir_mec = $_POST['cod_cita'];
    $_SESSION['cod_cita_a_anadir_mec'] = $cod_cita_a_anadir_mec;
    
    
    header("location:anadir_mecanico_a_cita_admin2.php");
    
      
}























