<?php

  include 'conexion_bd.php';
  session_start();
$opciones_citas_a_facturar = "";
$piezas_cita = "";

function mostrar_error($mensaje) {
    echo "<script language='JavaScript' type='text/javascript'>
        alert('$mensaje');
    </script>";
}


function pintar_formulario_facturar($opciones_citas_a_facturar, $piezas_cita) {
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
        <form action="facturar_cita.php" method="post">
            <h1>Facturar cita</h1>

            <p>
                Citas a facturar: 
                <select name="cod_cita">
                
                $opciones_citas_a_facturar
            
                </select>
            </p>
            
            <p>
            Selecciona las piezas usadas en la cita: <br>
                 $piezas_cita
           <br>
            </p>
            
            <p>
                <input type="submit" name="submit" value="Expedir Factura">
            </p>
        </form>
    </body>
    </html>
FORMULARIO;

    print $form;
}


if(empty($_POST)){
    
    
    $query_citas = "SELECT cod_cita, fecha_cita, matricula, tiene_factura, duracion_estimada_total, nif_mec, hora_cita FROM cita WHERE tiene_factura = 'NO' AND nif_mec IS NOT NULL";
    $res = mysqli_query($conex, $query_citas);
         
         while ($fila = mysqli_fetch_array($res)){
             
             $opciones_citas_a_facturar .= "<option value='{$fila['cod_cita']}'>({$fila['matricula']})-(Fecha:{$fila['fecha_cita']})-(Hora: {$fila['hora_cita']})</option>";
             
         }
        
        
        if (mysqli_connect_errno()) {
            echo "Error en la conexión a la base de datos.";
            exit();
        }
    
        
        $query_pieza = "SELECT * FROM pieza WHERE 1=1";
        
        $res_piezas = mysqli_query($conex, $query_pieza);
         
         while ($fila = mysqli_fetch_array($res_piezas)){
             
             $piezas_cita .= "<input type='checkbox' name='piezas[]' value='{$fila['cod_pieza']}'>{$fila['nombre']}(Precio:{$fila['precio']}€)<br>";
             
         }
        
        
        if (mysqli_connect_errno()) {
            echo "Error en la conexión a la base de datos.";
            exit();
        }
    
    
    
    
    
    
pintar_formulario_facturar($opciones_citas_a_facturar, $piezas_cita);    
    
   
    
}else{
    
     
     if (empty($_POST['piezas'])) {
         print 'selecciona piezas';
         $cod_cita_facturar = $_POST['cod_cita'];
             
         $tipos_servicios_cita = "";
         
         $query_precio_total_servicios_cita = "SELECT SUM(tc.precio) AS precio_total FROM tipo_cita tc JOIN servicios_por_cita spc ON tc.cod_tipo_cita = spc.cod_tipo_cita WHERE spc.cod_cita = '$cod_cita_facturar'";
         
         $res = mysqli_query($conex, $query_precio_total_servicios_cita);
         
         $precio_total_servicio;
         while ($fila = mysqli_fetch_array($res)){
             $precio_total_servicio = $fila['precio_total'];
             
         }
         
         $query = "INSERT INTO factura (cod_cita, precio_total) "
                . "VALUES ('$cod_cita_facturar', '$precio_total_servicio')";
        
        $res = mysqli_query($conex, $query) or die (mysqli_errno($conex));
        
        $cod_factura = mysqli_insert_id($conex);
        
        
        if($res){
           
             //header("location:menuAdmin.php");       
        }
         
        
        $query = "UPDATE cita SET tiene_factura='SI' WHERE cod_cita='$cod_cita_facturar'";
         $res = mysqli_query($conex, $query) or die (mysqli_errno($conex));

            
        
        
        
         
         
         
         
         
         
         
         
         
         
        $_SESSION['cod_cita_facturar'] = $cod_cita_facturar; 
        $_SESSION['precio_total_servicios'] = $precio_total_servicio; 
         
        header("location:facturar_cita2.php");
       
         
}else{
        
        $piezas_cita = $_POST['piezas'];
        $cod_cita_facturar = $_POST['cod_cita'];
        
         $tipos_servicios_cita = "";
         
         $query_precio_total_servicios_cita = "SELECT SUM(tc.precio) AS precio_total FROM tipo_cita tc JOIN servicios_por_cita spc ON tc.cod_tipo_cita = spc.cod_tipo_cita WHERE spc.cod_cita = '$cod_cita_facturar'";
         
         $res = mysqli_query($conex, $query_precio_total_servicios_cita);
         
         $precio_total_servicio;
         while ($fila = mysqli_fetch_array($res)){
             $precio_total_servicio = $fila['precio_total'];
             
         }
         
         
         
         $precio_total_piezas = 0;    
         
         foreach ($piezas_cita as $cod_pieza) {
        
        $query_precio = "SELECT precio FROM pieza WHERE cod_pieza = $cod_pieza";
        $res_precio = mysqli_query($conex, $query_precio);

        if ($res_precio && mysqli_num_rows($res_precio) > 0) {
           
            $fila = mysqli_fetch_assoc($res_precio);
            $precio_total_piezas += $fila['precio'];  
        } else {
            echo "Error al obtener el precio de la pieza con cod_pieza = $cod_pieza.";
        }
        }
        
        
    print "Precio total piezas: " .  $precio_total_piezas . "<br>";
        
        
        $precio_total_cita = $precio_total_servicio + $precio_total_piezas;
        
    
        print "Precio total cita: " .  $precio_total_cita;
        
        
        
        $query = "INSERT INTO factura (cod_cita, precio_total) "
                . "VALUES ('$cod_cita_facturar', '$precio_total_cita')";
        
        $res = mysqli_query($conex, $query) or die (mysqli_errno($conex));
        $cod_factura = mysqli_insert_id($conex);
        
        if($res){
           
             //header("location:menuAdmin.php");       
        }
        

        foreach ($piezas_cita as $cod_pieza) {
        $query = "INSERT INTO piezas_en_factura (cod_factura, cod_pieza) "
                . "VALUES ('$cod_factura', '$cod_pieza')";
        
        $res = mysqli_query($conex, $query) or die (mysqli_errno($conex));
        
        }
  
        
        
        $query = "UPDATE cita SET tiene_factura='SI' WHERE cod_cita='$cod_cita_facturar'";
          $res = mysqli_query($conex, $query) or die (mysqli_errno($conex));
        
        
        $_SESSION['cod_cita_facturar'] = $cod_cita_facturar; 
        $_SESSION['precio_total_cita'] = $precio_total_cita; 
         $_SESSION['cod_factura'] = $cod_factura;  
        header("location:facturar_cita3.php");
    
        
}
    
    
    

}


