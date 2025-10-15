<?php

session_start();

$nif_usu = $_SESSION['nif_usuario'];
$nombre_vehiculo = "";
$matricula = "";
$año = "";

function mostrar_error($mensaje) {
    echo "<script language='JavaScript' type='text/javascript'>
        alert('$mensaje');
    </script>";
}

function pintar_formulario_anadir_vehiculo($nif_usu, $nombre_vehiculo, $matricula, $año) {
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
        <form action="anadirVehiculo.php" method="post">
            <h1>Registro de vehículo</h1>
            
            <p>
                NIF_usuario: 
                <input name="nif_usuario" type="text" maxlength="9" value="$nif_usu" disabled>
            </p>
            
            <p>
                Matricula: 
                <input name="matricula" type="text"  maxlength="7" required>
            </p>
            
            <p>
                Nombre: 
                <input name="nombre_vehiculo" type="text" maxlength="20"  required>
            </p>
            
            <p>
                Año: 
                <input name="año" type="text" maxlength="4" required>
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

function validar_datos_vehiculo($nombre_vehiculo, $matricula, $año) {
    
    if (!preg_match("/[0-9]{4}[a-zA-Z]{3}$/", $matricula)) {
        mostrar_error("Matrícula mal.");
        return false;
    }
    
    // Validación de nombre de vehículo (no vacío)
    if ($nombre_vehiculo == "") {
        mostrar_error("Nombre de vehículo mal.");
        return false;
    }

    // Validación del año (4 dígitos)
    if (!preg_match("/^\d{4}$/", $año)) {
        mostrar_error("Año mal.");
        return false;
    }

    return true;
}

if (empty($_POST)) {
    pintar_formulario_anadir_vehiculo($nif_usu, $nombre_vehiculo, $matricula, $año);

    
    }else {
        
        $nombre_vehiculo = $_POST['nombre_vehiculo'];
        $matricula = $_POST['matricula'];
        $año = $_POST['año'];
        
    
    

    if (validar_datos_vehiculo($nombre_vehiculo, $matricula, $año)) {
        
        $conex = mysqli_connect('localhost', 'root', '') or die (mysqli_errno($conex));
        mysqli_select_db($conex, "trabajosw") or die (mysqli_errno($conex));

        if (mysqli_connect_errno()) {
            echo "Error en la conexión a la base de datos.";
            exit();
        }

        // Comprobar si la matrícula ya existe
        $query2 = "SELECT matricula FROM vehiculo WHERE matricula = '$matricula'";
        $res_valid2 = mysqli_query($conex, $query2);

        if (!$res_valid2) {
            echo "Error en la consulta de validación.";
            exit();
        }

        if (mysqli_num_rows($res_valid2) == 0) {
            
            $query = "INSERT INTO vehiculo (matricula, nombre_vehiculo, nif_usu, ano) VALUES ('$matricula', '$nombre_vehiculo', '$nif_usu', '$año')";
            $res = mysqli_query($conex, $query) or die (mysqli_errno($conex));

            if ($res) {
                header("Location: menuUsuario.php"); // Redirigir después de guardar
                //exit();
                
            } else {
                echo "Error al insertar el vehículo.";
                print $nif_usu . "<br>";
                print $matricula . "<br>";
                print $año . "<br>";
                print $nombre_vehiculo . "<br>";
                
                
                
                
                
                exit();
            }
        } else {
            mostrar_error("Ya existe un vehículo con esa matrícula.");
            pintar_formulario_anadir_vehiculo($nif_usu, $nombre_vehiculo, $matricula, $año);
        }
        
        
    } else {
        pintar_formulario_anadir_vehiculo($nif_usu, $nombre_vehiculo, $matricula, $año);
    }
        
        
        
    
    }

?>
