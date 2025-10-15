<?php
session_start();
  include 'conexion_bd.php';

$nif_usu = $_SESSION['nif_usuario'];
$opciones_matriculas = "";
$fecha_cita = "";
$hora_cita = "";
$matricula_seleccionada = "";
$fecha_fin = "";
$opciones_tipo_cita = "";

function mostrar_error_cita($mensaje) {
    echo "<script language='JavaScript' type='text/javascript'>
        alert('$mensaje');
    </script>";
}


function pintar_formulario_pedir_cita($nif_usu, $fecha_cita, $opciones_matriculas, $hora_cita, $opciones_tipo_cita) {
    $form = <<<FORMULARIO
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pedir cita</title>
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
        <form action="anadir_cita_usuario.php" method="post">
            <h1>Registro de cita</h1>
            
            <p>
                NIF_usuario: 
                <input name="nif_usuario" type="text" maxlength="9" value="$nif_usu" disabled>
            </p>
            
            <p>
                Matricula: 
                <select name="matricula">
                
                $opciones_matriculas
            
                </select>
            </p>
            
            <p>
            Selecciona los tipos de Cita para la cita: <br>
                 $opciones_tipo_cita
           <br>
            </p>
        
        
            <p>
                Fecha Cita(AAAA-MM-DD): 
                <input name="fecha_cita" type="date"  required>
            </p>
            
            
            <p>
                Hora Cita(HH:MM:SS): 
                <select name="hora_cita" id="hora_cita" required>
                    
                    <option value="09:00:00">09:00:00</option>
                    <option value="09:30:00">09:30:00</option>
                    <option value="10:00:00">10:00:00</option>
                    <option value="10:30:00">10:30:00</option>
                    <option value="11:00:00">11:00:00</option>
                    <option value="11:30:00">11:30:00</option>
                    <option value="12:00:00">12:00:00</option>
                    <option value="12:30:00">12:30:00</option>
                    <option value="13:00:00">13:00:00</option>
                    <option value="13:30:00">13:30:00</option>
                    <option value="14:00:00">14:00:00</option>
                    <option value="14:30:00">14:30:00</option>
                    <option value="16:00:00">16:00:00</option>
                    <option value="16:30:00">16:30:00</option>
                    <option value="17:00:00">17:00:00</option>
                    <option value="17:30:00">17:30:00</option>
                    <option value="18:00:00">18:00:00</option>
                    <option value="18:30:00">18:30:00</option>
                    <option value="19:00:00">19:00:00</option>
                    <option value="19:30:00">19:30:00</option>
            
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



function validar_datos($fecha_cita){
    
    if ((!preg_match("/^(\d{4})-(\d{2})-(\d{2})$/", $fecha_cita))){
        
        
        mostrar_error_cita("Fecha invalida introduce una fecha: AAAA-MM-DD");
        return false;
    }
    
    
    
    
    return true;
}








if(empty($_POST)){
    
    
    
    $query_matriculas = "SELECT matricula, nombre_vehiculo FROM vehiculo WHERE nif_usu='$nif_usu'";
    $res = mysqli_query($conex, $query_matriculas);
         
         while ($fila = mysqli_fetch_array($res)){
             
             $opciones_matriculas .= "<option value='{$fila['matricula']}'>{$fila['matricula']}({$fila['nombre_vehiculo']})</option>";
             
         }
        
        
        if (mysqli_connect_errno()) {
            echo "Error en la conexión a la base de datos.";
            exit();
        }
    
        
        $query_tipos_cita = "SELECT cod_tipo_cita, tipo_cita, precio FROM tipo_cita WHERE 1=1";
        
        $res_tipos_cita = mysqli_query($conex, $query_tipos_cita);
         
         while ($fila = mysqli_fetch_array($res_tipos_cita)){
             
             $opciones_tipo_cita .= "<input type='checkbox' name='tipos_cita[]' value='{$fila['cod_tipo_cita']}'>{$fila['tipo_cita']}(Precio:{$fila['precio']}€)<br>";
             
         }
        
        
        if (mysqli_connect_errno()) {
            echo "Error en la conexión a la base de datos.";
            exit();
        }
        
    pintar_formulario_pedir_cita($nif_usu, $fecha_cita, $opciones_matriculas, $hora_cita, $opciones_tipo_cita);
  
}else{
    
    
    if(empty($_POST['tipos_cita'])){
        
        mostrar_error_cita("Selecciona al menos un tipo de cita");
        header("location:anadir_cita_usuario.php");
        
        
    }else{
        
        $fecha_cita = $_POST['fecha_cita'];
        $hora_cita = $_POST['hora_cita'];
        $matricula_seleccionada = $_POST['matricula'];
        
        if(!validar_datos($fecha_cita)){
            
            header("location:anadir_cita_usuario.php");
            
        } else {
            
        
        
    




    
$servicios_seleccionados = $_POST['tipos_cita'];
    

    $duracion = "";
    
    $fecha_final_date = new DateTime($hora_cita);
    
    $duracion_estimada_total = new DateTime($fecha_cita);
    
    foreach ($servicios_seleccionados as $servicio) {
        
        
        $query_duracion = "SELECT cod_tipo_cita, tiempo_estimado, precio FROM tipo_cita WHERE cod_tipo_cita='$servicio'";
        $res_duracion = mysqli_query($conex, $query_duracion);
         
         while ($fila = mysqli_fetch_array($res_duracion)){
             $duracion = $fila['tiempo_estimado'];
             
            list($horas, $minutos, $segundos) = explode(':', $duracion);
            $interval = new DateInterval("PT{$horas}H{$minutos}M{$segundos}S");
            
            $fecha_final_date->add($interval);
            $duracion_estimada_total->add($interval);
            //$fecha_fin = $dateTime->format('H:i:s');
            
         }
        
            //echo $servicio ." " . $duracion . "<br>";
        }
        
        $fecha_final_date_str = $fecha_final_date->format("H:i:s");
        $duracion_estimada_total_str = $duracion_estimada_total->format("H:i:s");
        
        
           
            
        //print $fecha_cita . "<br>";
        //print $hora_cita . "<br>"; //Hora inicio cita
        //print $matricula_seleccionada . "<br>";
        
        //print 'Fecha de fin: ' . $fecha_final_date_str. "<br>"; //Hora de acabado
        
        //print 'Duracion estimada de la cita: ' . $duracion_estimada_total_str . "<br>"; //duracion estimada total
        
        
        
        $num_mecanicos_sistema = "";
        
        $query_num_mecanicos = "SELECT CAST(COUNT(*) AS UNSIGNED) AS num_mecanicos FROM mecanico";
        $res_num_mecanicos = mysqli_query($conex, $query_num_mecanicos);
         
         while ($fila = mysqli_fetch_array($res_num_mecanicos)){
             $num_mecanicos_sistema = $fila['num_mecanicos'];
         }
        
        
        if (mysqli_connect_errno()) {
            echo "Error en la conexión a la base de datos.";
            exit();
        }
        
        $num_mecanicos_sistema_num = intval($num_mecanicos_sistema);
        
            
             //print 'Num mecanicos : ' . $num_mecanicos_sistema_num;
            

                          
         //Comprobar numero de citas solapadas    
             
      
        $num_citas_solapadas = "";
        
        $query_num_citas_solapadas = "SELECT CAST(COUNT(*) AS UNSIGNED) AS citas_solapadas_dia FROM cita WHERE fecha_cita = '$fecha_cita' AND hora_cita < '$fecha_final_date_str' AND ADDTIME(hora_cita, duracion_estimada_total) > '$hora_cita'";
        $res_num_citas_solapadas = mysqli_query($conex, $query_num_citas_solapadas);
         
         while ($fila = mysqli_fetch_array($res_num_citas_solapadas)){
             $num_citas_solapadas = $fila['citas_solapadas_dia'];
         }
        
        
        if (mysqli_connect_errno()) {
            echo "Error en la conexión a la base de datos.";
            exit();
        }
        
        $num_citas_solapadas_num = intval($num_citas_solapadas);
        
            
             //print 'Num citas solapadas : ' . $num_citas_solapadas_num;     
             
             
             
       if($num_citas_solapadas_num < $num_mecanicos_sistema_num){
           
           
           
           
           $query_insertar_cita = "INSERT INTO cita (cod_cita, fecha_cita, matricula, tiene_factura, duracion_estimada_total, nif_mec, hora_cita) VALUES (NULL, '$fecha_cita', '$matricula_seleccionada', 'NO', '$duracion_estimada_total_str', NULL, '$hora_cita')";
        
           $res_insert_cita = mysqli_query($conex, $query_insertar_cita) or die (mysqli_errno($conex));
        
              
             
             $cod_cita_generado = mysqli_insert_id($conex);
           
             
         foreach ($servicios_seleccionados as $servicio) {
        
        
        $query_servicios_cita = "INSERT INTO servicios_por_cita (cod_cita, cod_tipo_cita) VALUES('$cod_cita_generado', '$servicio')";
        $res_servicios_cita = mysqli_query($conex, $query_servicios_cita);
         
         
        }
             
             if($res_servicios_cita){
           
                header("location:menuUsuario.php");       
             }
             
             
             
       }else{
           mostrar_error_cita("No hay mecanicos disponibles elije otro dia o hora");
           pintar_formulario_pedir_cita($nif_usu, $fecha_cita, $opciones_matriculas, $hora_cita, $opciones_tipo_cita);
       }      
                       
        
       
}
      
}



}




