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

// Verificar si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Procesar acción de encender o apagar la luz
if (isset($_POST['toggle_LED'])) {
    $sql = "SELECT * FROM LED_status WHERE id = 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row['status'] == 0) {
        $update = mysqli_query($conn, "UPDATE LED_status SET status = 1 WHERE id = 1");
    } else {
        $update = mysqli_query($conn, "UPDATE LED_status SET status = 0 WHERE id = 1");
    }
}

// Obtener estado actual de la luz
$sql = "SELECT * FROM LED_status WHERE id = 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$current_status = $row['status'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control de Luz</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 50px;
        }
        h1, h2 {
            color: #333;
        }
        form {
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Control de Luz</h1>
    <h2>Estado actual de la luz: <?php echo ($current_status == 1) ? "Encendido" : "Apagado"; ?></h2>
    <form action="control_luz.php" method="post">
        <input type="submit" name="toggle_LED" value="<?php echo ($current_status == 1) ? "Apagar LED" : "Encender LED"; ?>">
    </form>
    <br>
    <a href="index.php">Volver al inicio</a>
</body>
</html>
