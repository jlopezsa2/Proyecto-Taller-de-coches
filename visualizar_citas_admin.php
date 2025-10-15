<?php


include 'conexion_bd.php';



$query = "SELECT cod_cita, fecha_cita, matricula,tiene_factura, duracion_estimada_total, nif_mec, hora_cita FROM cita WHERE 1";

$res = mysqli_query($conex, $query) or die (mysqli_error($conex));

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas</title>
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

    <h1>Todas las citas</h1>

    <div class="table-container">
        <?php if (mysqli_num_rows($res) > 0) { ?>
            <table>
                <thead>
                    <tr>
                        <th>Codigo cita</th>
                        <th>Fecha cita</th>
                        <th>Matricula</th>
                        <th>Facturada?</th>
                        <th>Duracion Estimada</th>
                        <th>NIF mecanico</th>
                        <th>Hora cita</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = mysqli_fetch_array($res)) { ?>
                        <tr>
                            <td><?php echo $fila['cod_cita']; ?></td>
                            <td><?php echo $fila['fecha_cita']; ?></td>
                            <td><?php echo $fila['matricula']; ?></td>
                            <td><?php echo $fila['tiene_factura']; ?></td>
                            <td><?php echo $fila['duracion_estimada_total']; ?></td>
                            <td><?php echo $fila['nif_mec']; ?></td>
                            <td><?php echo $fila['hora_cita']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p class="no-citas">No hay citas en el sistema</p>
        <?php } ?>
    </div>

</body>
</html>

<?php

mysqli_close($conex);
?>
