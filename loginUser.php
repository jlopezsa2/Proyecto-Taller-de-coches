<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Iniciar Sesión</title>
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
            }

            /* Main Form Container */
            form {
                background-color: #fff;
                padding: 30px;
                border-radius: 8px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                width: 300px;
                box-sizing: border-box;
                text-align: center;
            }

            /* Heading Style */
            h1 {
                color: #333;
                font-size: 24px;
                margin-bottom: 20px;
                font-weight: bold;
            }

            label {
                color: #555;
                font-size: 14px;
                display: block;
                margin-bottom: 5px;
                text-align: left;
            }

            /* Input Fields */
            input[type="text"], input[type="password"] {
                width: 100%;
                padding: 10px;
                margin: 10px 0;
                border: 1px solid #ddd;
                border-radius: 4px;
                box-sizing: border-box;
                font-size: 16px;
            }

            /* Submit Button */
            input[type="submit"] {
                background-color: #4CAF50;
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 4px;
                cursor: pointer;
                font-size: 16px;
                width: 100%;
                transition: background-color 0.3s ease;
            }

            input[type="submit"]:hover {
                background-color: #45a049;
            }

            /* Footer - Register Link */
            .form-footer {
                text-align: center;
                margin-top: 15px;
            }

            .form-footer a {
                color: #4CAF50;
                text-decoration: none;
                font-size: 14px;
                transition: color 0.3s ease;
            }

            .form-footer a:hover {
                color: #388e3c;
            }

            p {
                margin: 0;
                padding: 0;
            }
            
            
            a {
                display: inline-block;
                margin-top: 10px;
                margin-bottom: 20px;
                color: #4CAF50;
                text-decoration: none;
                font-size: 14px;
                transition: color 0.3s ease;
            }

            a:hover {
                color: #388e3c;
            }
        </style>
    </head>
    <body>
        
            <form action="validar_usuario.php" method="post">
                <h1>Iniciar Sesión</h1>
                
                <p>
                    <label for="nif_usuario">Nif:</label>
                    <input name="nif_usuario" type="text" id="nif_usuario" maxlength="9" required>
                </p>
                
                <p>
                    <label for="clave">Contraseña:</label>
                    <input name="clave" type="password" id="clave" required>
                </p>
                <p>
                    
                    <a href="index.php">Registrar Nuevo Usuario</a></p>
                <p>
                    <input name="submit" type="submit" value="Iniciar sesión">
                </p>
            </form>
            
            
       
    </body>
</html>
