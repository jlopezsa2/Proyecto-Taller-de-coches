<?php
// En la tabla usuario hay que añadir a mano antes un usuario especial
// con nif: adminT y clave 12345678
include 'conexion_bd.php';

$nif_Admin = "adminT";
$claveAdmin = "";

function pintar_formulario($nif_Admin, $claveAdmin){
    $formulario1 = <<<FORMULARIO1
    <style>
        /* Estilos para el formulario de administrador */
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

        .form-container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        form p {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: inline-block;
            text-align: left;
            width: 100%;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        input:disabled {
            background-color: #f0f0f0;
            color: #888;
            cursor: not-allowed;
        }

        form p:last-child {
            margin-top: 20px;
        }

        form p {
            font-size: 18px;
            color: #555;
        }
    </style>

    <form action="validar_administrador.php" method="post">
        <div class="form-container">
            <h1>Inicio para Administrador</h1>
            
            <p>
                <label for="nif_admin">Usuario Administrador:</label>
                <input id="nif_admin" name="nif_admin" type="text" size="9" maxlength="9" value="adminT" disabled>
            </p>
            
            <p>
                <label for="clave">Contraseña:</label>
                <input id="clave" name="clave" type="password" maxlength="20" required>
            </p>
            
            <p>
                <input type="submit" name="submit" value="Entrar">
            </p>
        </div>
    </form>
FORMULARIO1;
    print $formulario1;
}

if (empty($_POST)){
    pintar_formulario($nif_Admin, $claveAdmin);
} else {
    $claveAdmin = $_POST['clave'];
    $query = "SELECT clave FROM usuario WHERE nif_usu = '$nif_Admin' AND clave = '$claveAdmin'";
    
    $res_valid = mysqli_query($conex, $query) or die (mysqli_error($conex));

    if ((mysqli_num_rows($res_valid) == 1)){
        header("location: menuAdmin.php");
    } else {
        pintar_formulario($nif_Admin, $claveAdmin);
    }
}
?>
