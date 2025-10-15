<?php
session_start();

$nif_usuario = $_SESSION['nif_usuario'];
$nombre_usuario = $_SESSION['nombre_usuario'];
$apellidos = $_SESSION['apellidos'];
$clave = $_SESSION['clave'];


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Usuario</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
        }

        /* Main Container */
        .container {
            text-align: center;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
        }

        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        /* Button Style */
        .btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin: 10px 0;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .btn-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        /* Link to Logout */
        .logout {
            text-decoration: none;
            color: #4CAF50;
            font-size: 14px;
            margin-top: 15px;
            transition: color 0.3s ease;
        }

        .logout:hover {
            color: #388e3c;
        }

        /* Greeting */
        .greeting {
            margin-bottom: 30px;
            font-size: 18px;
            color: #333;
        }

    </style>
</head>
<body>

<div class="container">
    <!-- Greeting message -->
    <div class="greeting">
        <?php
        echo 'Hola: '. $nombre_usuario . " ". $apellidos;
        ?>
    </div>

    <!-- Button Container -->
    <div class="btn-container">
        <a href="anadirVehiculo.php">
            
            <button class="btn">Añadir Nuevo Vehículo</button>
        </a>
        <a href="mostrar_vehiculos_usuario.php">
            <button class="btn">Ver Vehículos</button>
        </a>
        <a href="anadir_cita_usuario.php">
            <button class="btn">Pedir Cita</button>
        </a>
        <a href="mostrar_citas_usuario.php">
            <button class="btn">Ver Historial de Citas</button>
        </a>
        
        
        <a href="modificar_cita_usuario.php">
            <button class="btn">Modificar Cita</button>
        </a>
        
        <a href="cancelar_cita_usuario.php">
            <button class="btn">Cancelar Cita</button>
        </a>
    </div>

    <!-- Logout Link -->
    <a href="index.php" class="logout">Cerrar sesión</a>
</div>

</body>
</html>













