<?php

include 'conexion_bd.php';

session_start();

$opciones_mecanicos = "";
$cod_cita = $_SESSION['cod_cita_a_anadir_mec'];

$nif_mec = "";

//print "Codigo de la cita" .$cod_cita . "<br>";



function pintar_formulario_seleccionar_mecanico($opciones_mecanicos) {
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
        <form action="anadir_mecanico_a_cita_admin2.php" method="post">
            <h1>Asociar mecanico a cita</h1>
            
            
            <p>
                Seleccion de mecanico: 
                <select name="nif_mec">
                
                $opciones_mecanicos
            
                </select>
            </p>
                
            
            <p>
                <input type="submit" name="submit" value="Guardar">
            </p>
        </form>
    </body>
    </html>
FORMULARIO;

    print $form;
}


if(empty($_POST)){
    
    $query_seleccionar_datos_cita = "SELECT cod_cita, fecha_cita, matricula, tiene_factura, duracion_estimada_total, nif_mec, hora_cita FROM cita WHERE cod_cita = '$cod_cita'";
    $res = mysqli_query($conex, $query_seleccionar_datos_cita);
         
    $fecha_cita = "";
    $hora_cita = "";
    $duracion_estimada_total = "";
    
    
         while ($fila = mysqli_fetch_array($res)){
             $fecha_cita = $fila['fecha_cita'];
             $hora_cita = $fila['hora_cita'];
             $duracion_estimada_total = $fila['duracion_estimada_total'];
         }
        
        
        if (mysqli_connect_errno()) {
            echo "Error en la conexión a la base de datos.";
            exit();
        }
    
    
        //print $fecha_cita . "<br>";
        //print $hora_cita . "<br>";
        //print $duracion_estimada_total . "<br>";
        
        
        $hora_cita_obj = new DateTime($hora_cita);

    
    $intervalo = new DateInterval('PT' . explode(':', $duracion_estimada_total)[0] . 'H' .
                              explode(':', $duracion_estimada_total)[1] . 'M' .
                              explode(':', $duracion_estimada_total)[2] . 'S');

    
    $hora_cita_obj->add($intervalo);
    $hora_fin = $hora_cita_obj->format('H:i:s');
    //echo "Hora final: " . $hora_fin;
        
    //Encontrar mecanicos disponibles
    
    $query_seleccionar_mecanicos = "SELECT m.nif_mec FROM mecanico m WHERE m.nif_mec NOT IN (SELECT c.nif_mec FROM cita c WHERE c.fecha_cita = '$fecha_cita' AND c.nif_mec IS NOT NULL AND c.hora_cita < '$hora_fin' AND ADDTIME(c.hora_cita, c.duracion_estimada_total) > '$hora_cita')";
    $res_mecanicos = mysqli_query($conex, $query_seleccionar_mecanicos);
    
    while ($fila = mysqli_fetch_array($res_mecanicos)){
        
            $nif_mec = $fila['nif_mec']; 
            $query_seleccionar_nombre = "SELECT nombre, apellidos FROM mecanico WHERE nif_mec = '$nif_mec'";
            $res_mecanicos_nombre_apellidos = mysqli_query($conex, $query_seleccionar_nombre);
        
        
            
            while ($fila2 = mysqli_fetch_array($res_mecanicos_nombre_apellidos)){
                
                
                $opciones_mecanicos .= "<option value='{$nif_mec}'>({$fila2['nombre']}){$fila2['apellidos']}</option>";
            }
            
         }
        
        
        if (mysqli_connect_errno()) {
            echo "Error en la conexión a la base de datos.";
            exit();
        }
       
        
        
        
        pintar_formulario_seleccionar_mecanico($opciones_mecanicos);
}else{
    
    
    $nif_mec = $_POST['nif_mec'];
    
            $query_anadir_mec_cita = "UPDATE cita SET nif_mec='$nif_mec' WHERE cod_cita = '$cod_cita'";
            $res = mysqli_query($conex, $query_anadir_mec_cita) or die (mysqli_errno($conex));

            if ($res) {
                header("Location: menuAdmin.php"); 
               
                
            } else {
                
                mostrar_error("No se ha modificado error");
                pintar_formulario_seleccionar_mecanico($opciones_mecanicos);
                
            }
    
    
    
    
    
    
    
    
}





