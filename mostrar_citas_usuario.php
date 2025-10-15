<?php

session_start();
include 'conexion_bd.php';

$nif_usuario = $_SESSION['nif_usuario'];
$nombre_usuario = $_SESSION['nombre_usuario'];

$query = "SELECT cita.* FROM cita JOIN vehiculo ON cita.matricula = vehiculo.matricula WHERE vehiculo.nif_usu = '$nif_usuario'";

$res = mysqli_query($conex, $query) or die (mysqli_error($conex));

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas de <?php echo $nombre_usuario; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        .table-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .no-citas {
            text-align: center;
            font-size: 18px;
            color: #888;
        }

    </style>
</head>
<body>

    <h1>Citas de <?php echo $nombre_usuario; ?></h1>

    <div class="table-container">
        <?php if (mysqli_num_rows($res) > 0) { ?>
            <table>
                <thead>
                    <tr>
                        <th>Cod cita</th>
                        <th>Fecha Cita</th>
                        <th>Matricula</th>
                        <th>Duracion (h:m:s)</th>
                        <th>Hora Cita</th>
                        
                        
                        
                        
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = mysqli_fetch_array($res)) { ?>
                        <tr>
                            <td><?php echo $fila['cod_cita']; ?></td>
                            <td><?php echo $fila['fecha_cita']; ?></td>
                            <td><?php echo $fila['matricula']; ?></td>
                            <td><?php echo $fila['duracion_estimada_total']; ?></td>
                            <td><?php echo $fila['hora_cita']; ?></td>
                            
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p class="no-citas">No tienes citas registradas</p>
        <?php } ?>
    </div>

</body>
</html>

<?php

mysqli_close($conex);
?>
