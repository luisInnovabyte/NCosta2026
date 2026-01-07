<?php
  session_start();
function checkAccess($rolesRequeridos) {
  
  if (isset($_SESSION['usu_rol'])) {
    if (in_array($_SESSION['usu_rol'], $rolesRequeridos) ) {
      // El usuario tiene uno de los roles requeridos, se permite el acceso
      return true;
    } else {
      // El usuario no tiene ninguno de los roles requeridos, se redirige a la página de login
      
    echo '<!DOCTYPE html>
    <html>
    <head>
        <title>Página de Inicio</title>
        <style>
            body {
                background-color: #007bff;
                color: white;
                text-align: center;
            }
           .boton-iniciar-sesion {
            background-color: #6A5ACD; /* Color morado */
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }
        </style>
    </head>
    <body>
        <h1>Sesión Cerrada</h1>
        <p>Por favor, inicia sesión para acceder a tu cuenta.</p>
        <a href="../../view/Login/index.php" class="boton-iniciar-sesion">Iniciar Sesión</a>
    </body>
    </html>';
      header('Location: ../../view/Login/index.php');
      exit();
    }
  } else {
    // El usuario no está autenticado, se redirige a la página de login

    echo '<!DOCTYPE html>
    <html>
    <head>
        <title>Página de Inicio</title>
        <style>
            body {
                background-color: #007bff;
                color: white;
                text-align: center;
            }
           .boton-iniciar-sesion {
            background-color: #6A5ACD; /* Color morado */
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }
        </style>
    </head>
    <body>
        <h1>Sesión Cerrada</h1>
        <p>Por favor, inicia sesión para acceder a tu cuenta.</p>
        <a href="../../view/Login/index.php" class="boton-iniciar-sesion">Iniciar Sesión</a>
    </body>
    </html>';

    header('Location: ../../view/Login/index.php');
    exit();
  }
}
?>