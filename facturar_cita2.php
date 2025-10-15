<?php

session_start();
include 'conexion_bd.php';


$cod_cita_facturar = $_SESSION['cod_cita_facturar']; 
$precio_total_servicio = $_SESSION['precio_total_servicios'];    
$cod_factura = $_SESSION['cod_factura'];

$query_servicios_cita = "SELECT tc.tipo_cita, tc.precio 
                         FROM tipo_cita tc 
                         JOIN servicios_por_cita spc 
                         ON tc.cod_tipo_cita = spc.cod_tipo_cita 
                         WHERE spc.cod_cita = $cod_cita_facturar;";

$res = mysqli_query($conex, $query_servicios_cita);

?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios de la Cita</title>
    <link rel="stylesheet" href="styles.css"> 
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
            flex-direction: column;
            padding: 20px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
            font-size: 18px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        td {
            font-size: 16px;
            color: #555;
        }

        .total {
            margin-top: 20px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }

        .total span {
            color: #4CAF50;
        }

        .container {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
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
        
        
        

    </style>
</head>
<body>

    <div class="container">
        <h2>Servicios de la cita con cod_cita = <?php echo htmlspecialchars($cod_cita_facturar); ?></h2>
        
        <table>
            <tr>
                <th>Servicio</th>
                <th>Precio (€)</th>
            </tr>

            <?php
            while ($fila = mysqli_fetch_assoc($res)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($fila['tipo_cita']) . "</td>";
                echo "<td>" . number_format($fila['precio'], 2) . "€</td>";
                echo "</tr>";
            }
            ?>
        </table>

        <?php if ($precio_total_servicio) { ?>
            <div class="total">
                <p>Precio Total: <span><?php echo number_format($precio_total_servicio, 2); ?>€</span></p>
            </div>
        <?php } ?>

    </div>
    
    <a href="menuAdmin.php">
            <button class="btn">Ir a menu principal</button>
        </a>

</body>
</html>
