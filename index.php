<?php
session_start();

$servername = "localhost";
$dBUsername = "id22396116_tatto";
$dBPassword = "Derecho388@";
$dBName = "id22396116_tatto";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Verificar inicio de sesión
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE username = ? AND password = ?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "Error de SQL";
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            $_SESSION['username'] = $username;
            header("Location: index.php"); // Redirige a la página principal o a donde sea necesario
            exit();
        } else {
            echo '<script>alert("Usuario o contraseña incorrectos.");</script>';
        }
    }
}

// Cerrar sesión
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de LED</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('/campous.jpg'); /* Ruta ajustada según la ubicación de la imagen */
            background-size: cover;
            background-position: center;
            background-attachment: fixed; /* Fija la imagen de fondo */
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .content {
            text-align: center;
            background: rgba(255, 255, 255, 0.8); /* Fondo blanco semi-transparente */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 300px;
            margin: 20px;
        }
        form {
            background: #f0f0f0;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 300px;
            margin: 0 auto;
        }
        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 12px; /* Aumenta el padding para hacer los botones más grandes */
            margin: 8px 0; /* Aumenta el margen */
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px; /* Aumenta el tamaño de fuente */
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <?php if (isset($_SESSION['username'])): ?>
                <!-- Contenido cuando el usuario está autenticado -->
                <h1>Bienvenido, <?php echo $_SESSION['username']; ?>!</h1>
                <form action="index.php" method="post">
                    <input type="submit" name="logout" value="Cerrar sesión">
                </form>

                <!-- Enlace al control de la luz -->
                <h2>Control de LED</h2>
                <p><a href="control_luz.php">Ir al control de la luz</a></p>
            <?php else: ?>
                <!-- Formulario de inicio de sesión -->
                <h2>Iniciar Sesión</h2>
                <form action="index.php" method="post">
                    <label for="username">Usuario:</label>
                    <input type="text" id="username" name="username" required><br><br>
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required><br><br>
                    <input type="submit" name="login" value="Iniciar sesión">
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
