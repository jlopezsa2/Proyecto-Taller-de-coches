<?php
session_start();
  include 'conexion_bd.php';

$nif_usu = $_SESSION['nif_usuario'];
$opciones_matriculas = "";
$fecha_cita = "";
$hora_cita = "";
$matricula_seleccionada = "";
$fecha_fin = "";
$opciones_citas = "";

function mostrar_error($mensaje) {
    echo "<script language='JavaScript' type='text/javascript'>
        alert('$mensaje');
    </script>";
}




function pintar_formulario_modificar_cita($nif_usu, $opciones_matriculas, $opciones_citas) {
    $form = <<<FORMULARIO
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Modificar cita</title>
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
        <form action="modificar_cita_usuario.php" method="post">
            <h1>Modificar cita existente</h1>
            
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
            Selecciona la cita a modificar (Solo si no tiene ya mecanico asignado): <br>
                <select name="cod_cita">
                 $opciones_citas
                </select>
           <br>
            </p>
        
        
            <p>
                Fecha Cita(AAAA-MM-DD): 
                <input name="fecha_cita" type="text" maxlength="10"  required>
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
    
        
        
        
        $query_citas = "SELECT cita.* FROM cita JOIN vehiculo ON cita.matricula = vehiculo.matricula WHERE vehiculo.nif_usu = '$nif_usu' AND cita.nif_mec IS NULL";
        
        $res_citas = mysqli_query($conex, $query_citas);
         
         while ($fila = mysqli_fetch_array($res_citas)){
             
             $opciones_citas .= "<option value='{$fila['cod_cita']}'>({$fila['matricula']})-(Fecha:{$fila['fecha_cita']})-(Hora: {$fila['hora_cita']})</option>";
         }
        
        
        if (mysqli_connect_errno()) {
            echo "Error en la conexión a la base de datos.";
            exit();
        }
        
        
        
        
        pintar_formulario_modificar_cita($nif_usu, $opciones_matriculas, $opciones_citas);
        
        
        
    
}else{
    
    $cod_cita_modificar = $_POST['cod_cita'];
    $matricula_modificar = $_POST['matricula'];
    $fecha_cita_modificar = $_POST['fecha_cita'];
    $hora_cita_modificar = $_POST['hora_cita'];
    $duracion_estimada_cita_a_modificar = "";
    
    
    $query_duracion_cita = "SELECT cod_cita, fecha_cita, matricula, tiene_factura, duracion_estimada_total, nif_mec, hora_cita FROM cita WHERE cod_cita = '$cod_cita_modificar'";
        
        $res_duracion = mysqli_query($conex, $query_duracion_cita);
         
         while ($fila = mysqli_fetch_array($res_duracion)){
             $duracion_estimada_cita_a_modificar = $fila['duracion_estimada_total'];
         }
        
        
        if (mysqli_connect_errno()) {
            echo "Error en la conexión a la base de datos.";
            exit();
        }
    
        print "Fecha cita: " .$fecha_cita_modificar . "<br>";
        print "Duracion: " .$duracion_estimada_cita_a_modificar . "<br>";
        print "Hora cita: " .$hora_cita_modificar . "<br>";
        print "Matricula: " .$matricula_modificar . "<br>";
        
        
        $hora_inicio = new DateTime($hora_cita_modificar);
        $duracion = new DateInterval('PT' . explode(':', $duracion_estimada_cita_a_modificar)[0] . 'H' . explode(':', $duracion_estimada_cita_a_modificar)[1] . 'M' . explode(':', $duracion_estimada_cita_a_modificar)[2] . 'S');

        
        $hora_inicio->add($duracion);

        
        $hora_fin = $hora_inicio->format('H:i:s');

        echo "Hora de fin: " . $hora_fin. "<br>"; //Hora fin de cita
        
        //Comprobar disponibilidad de la cita y mecanicos 
        
        
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
        
            
             print 'Num mecanicos : ' . $num_mecanicos_sistema_num;
        
        
        //-----------------
        
        
    
             $num_citas_solapadas = "";
        
        $query_num_citas_solapadas = "SELECT COUNT(*) AS citas_solapadas_dia FROM cita WHERE fecha_cita = '$fecha_cita_modificar' AND hora_cita < '$hora_fin' AND ADDTIME(hora_cita, duracion_estimada_total) > '$hora_cita_modificar' AND cod_cita != '$cod_cita_modificar'";
        
        $res_num_citas_solapadas = mysqli_query($conex, $query_num_citas_solapadas);
         
         while ($fila = mysqli_fetch_array($res_num_citas_solapadas)){
             $num_citas_solapadas = $fila['citas_solapadas_dia'];
         }
        
        
        if (mysqli_connect_errno()) {
            echo "Error en la conexión a la base de datos.";
            exit();
        }
        
        $num_citas_solapadas_num = intval($num_citas_solapadas);
        
            
             print 'Num citas solapadas : ' . $num_citas_solapadas_num; 
             
             
                  
        if($num_citas_solapadas_num < $num_mecanicos_sistema_num){
             
           $query_actualizar_cita = "UPDATE cita SET fecha_cita='$fecha_cita_modificar',matricula ='$matricula_modificar',hora_cita='$hora_cita_modificar' WHERE cod_cita = '$cod_cita_modificar'";
        
           $res_update_cita = mysqli_query($conex, $query_actualizar_cita) or die (mysqli_errno($conex));
        
              
                  
             
             if($res_update_cita){
           
                header("location:menuUsuario.php");       
             }
             
             
             
       }else{
           
           mostrar_error("Elije otro dia o hora no hay mecanicos disponibles");
           header("location:menuUsuario.php");  
       }
             
             
        
    
}

    
    


