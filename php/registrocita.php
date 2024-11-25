<?php
session_start();
include_once 'db.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html"); 
    exit();
}


if (isset($_SESSION['usuario_id']) && !empty($_SESSION['usuario_id'])) {

    // Verificar si los datos del formulario están presentes
    if (isset($_POST['fecha']) && isset($_POST['hora'])) {

        // Obtener los valores del formulario y sanitizar los inputs
        $fecha = trim($_POST['fecha']);
        $hora = trim($_POST['hora']);
        $user_id = $_SESSION['usuario_id']; // ID del usuario logueado

        // Validación básica de los campos
        if (empty($fecha) || empty($hora)) {
            echo "<script>alert('Por favor, completa todos los campos de la cita.'); window.history.back();</script>";
            exit();
        }

        // Conectar a la base de datos
        $db = new Database();
        $con = $db->connect();

        // Preparar la consulta SQL usando sentencias preparadas para evitar inyecciones SQL
        $sql = "INSERT INTO CITA (ID_CLIENTE, FECHA_SOLICITUD, HORA) 
                VALUES (?, ?, ?)";
        $stmt = $con->prepare($sql);

        // Verificar si la consulta se preparó correctamente
        if ($stmt) {
            $stmt->bind_param("iss", $user_id, $fecha, $hora); // 'i' para integer, 's' para string
            $result = $stmt->execute();

            // Comprobar si la consulta fue exitosa
            if ($result) {
                // Redirigir al usuario a la página de inicio después de registrar la cita
                header("Location: ../home.php");
                exit();
            } else {
                echo "<script>alert('Error al registrar la cita: " . $stmt->error . "'); window.history.back();</script>";
            }

            $stmt->close(); // Cerrar la sentencia
        } else {
            echo "<script>alert('Error al preparar la consulta.'); window.history.back();</script>";
        }

        $con->close();
    } else {
        echo "<script>alert('Debe llenar todos los campos de la cita.'); window.history.back();</script>";
    }

} else {
    echo "<script>alert('Debe iniciar sesión para registrar una cita.'); window.history.back();</script>";
}
?>
