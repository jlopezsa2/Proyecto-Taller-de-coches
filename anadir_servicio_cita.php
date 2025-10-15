<?php


$tipo_cita = "";
$precio = "";
$tiempo_estimado = "";


function mostrar_error($mensaje) {
    echo "<script language='JavaScript' type='text/javascript'>
        alert('$mensaje');
    </script>";
}

function pintar_formulario_anadir_tipo_cita($tipo_cita, $precio, $timepo_estimado) {
    $formVehiculo = <<<FORMULARIO
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
        <form action="anadir_servicio_cita.php" method="post">
            <h1>Insertar nuevo servicio para cita</h1>
            
            <p>
                Nombre servicio de cita: 
                <input name="tipo_servicio" type="text" maxlength="40" required>
            </p>
            
            <p>
                Precio: 
                <input name="precio" type="number"  maxlength="7" step="0.01" min="0" placeholder="0.00" required>
            </p>
            
            <p>
                Tiempo estimado(HH:MM:SS): 
                <input name="tiempo_estimado" type="text" maxlength="8"  required>
            </p>
           
            
            <p>
                <input type="submit" name="submit" value="Guardar">
            </p>
        </form>
    </body>
    </html>
FORMULARIO;

    print $formVehiculo;
}

function validar_datos_tipo_cita($tipo_cita, $precio, $tiempo_estimado) {
    
    /*if (!preg_match('/^([01]?[0-9]|2[0-3]):([0-5]?[0-9]):([0-5]?[0-9])$/', $tie)) {
        mostrar_error("Tiempo estimado no sigue patron.");
        return false;
    }*/
    
    // Validación de nombre de vehículo (no vacío)
    if ($tipo_cita == "") {
        mostrar_error("Tipo de cita mal.");
        return false;
    }

    // Validación del año (4 dígitos)
    if (!preg_match('/^\d{1,8}(\.\d{1,2})?$/', $precio)) {
        mostrar_error("Precio debe ir con . y dos decimales");
        return false;
    }

    return true;
}

if (empty($_POST)) {
    pintar_formulario_anadir_tipo_cita($tipo_cita, $precio, $tiempo_estimado);

    
    }else {
        
        
        
        $tipo_cita = $_POST['tipo_servicio'];
        $precio = $_POST['precio'];
        $tiempo_estimado = $_POST['tiempo_estimado'];
    
    

    if (validar_datos_tipo_cita($tipo_cita, $precio, $tiempo_estimado)) {
        
        $conex = mysqli_connect('localhost', 'root', '') or die (mysqli_errno($conex));
        mysqli_select_db($conex, "trabajosw") or die (mysqli_errno($conex));

        if (mysqli_connect_errno()) {
            echo "Error en la conexión a la base de datos.";
            exit();
        }
     
            $query = "INSERT INTO tipo_cita (tipo_cita, precio, tiempo_estimado) VALUES ('$tipo_cita', '$precio', '$tiempo_estimado')";
            $res = mysqli_query($conex, $query) or die (mysqli_errno($conex));

            if ($res) {
                header("Location: menuAdmin.php"); // Redirigir después de guardar
                //exit();
                
            } else {
                
                mostrar_error("No se ha insertado error");
                pintar_formulario_anadir_tipo_cita($tipo_cita, $precio, $timepo_estimado);
                
            }
         
        
        
    } else {
       pintar_formulario_anadir_tipo_cita($tipo_cita, $precio, $timepo_estimado);
    }

    }

?>

