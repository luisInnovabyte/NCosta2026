<?php
// Archivo temporal para probar la pantalla de sesión cerrada
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesión Cerrada - Costa de Valencia</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: linear-gradient(135deg, #1AA3E8 0%, #0d6efd 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 480px;
            width: 100%;
            padding: 3rem 2.5rem;
            text-align: center;
            animation: slideIn 0.4s ease-out;
        }
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .icon-container {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, #1AA3E8 0%, #0d6efd 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(26, 163, 232, 0.7);
            }
            50% {
                box-shadow: 0 0 0 15px rgba(26, 163, 232, 0);
            }
        }
        .icon-container i {
            font-size: 2.5rem;
            color: white;
        }
        h1 {
            color: #2c3e50;
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }
        p {
            color: #6c757d;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        .btn-login {
            background: linear-gradient(135deg, #1AA3E8 0%, #0d6efd 100%);
            color: white;
            padding: 0.875rem 2.5rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
            font-weight: 500;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(26, 163, 232, 0.3);
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(26, 163, 232, 0.4);
        }
        .btn-login i {
            font-size: 1.25rem;
        }
        .footer-text {
            margin-top: 2rem;
            font-size: 0.875rem;
            color: #95a5a6;
        }
        @media (max-width: 480px) {
            .container {
                padding: 2rem 1.5rem;
            }
            h1 {
                font-size: 1.5rem;
            }
            .btn-login {
                padding: 0.75rem 2rem;
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon-container">
            <i class="bx bx-lock-alt"></i>
        </div>
        <h1>Sesión Cerrada</h1>
        <p>Por favor, inicia sesión para acceder a tu cuenta y continuar trabajando en el sistema.</p>
        <a href="./view/Login/index.php" class="btn-login">
            <i class="bx bx-log-in"></i>
            Iniciar Sesión
        </a>
        <p class="footer-text">Costa de Valencia © 2026</p>
    </div>
</body>
</html>
