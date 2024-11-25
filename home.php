<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit();
}

// Actualizar la cookie de última sesión
setcookie('ultima_sesion', date('d-m-Y H:i:s'), time() + (86400 * 30), "/"); // Expira en 30 días
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juan Mecanico</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body id="home">
<header>
    <div class="header-content">
        <a href="home.php"><img src="images/con_fondo-removebg-preview (1).png" alt="Logo Juan Mecanico" class="logo"></a>
        <div class="contact-info">Contactanos: 1234-5678 / 5678-1234</div>
        <div class="hours">Horario de atención: lunes a sábado de 8:00 am a 6:00 pm</div>
    </div>
    <div class="dropdown">
        <button class="dropbtn">&#9776; Opciones</button>
        <div class="dropdown-content">
            <a href="home.php">Inicio</a>
            <a href="registrocitas.html">Registro de Citas</a>
            <a href="soporte.html">Soporte</a>
            <a href="logout.php">Cerrar sesión</a>
        </div>
    </div>
</header>

<main>
    <!-- Contenido principal -->
</main>

<footer>
    <nav class="main-nav">
        <ul>
            <li><a href="home.php">Inicio</a></li>
            <li><a href="registrocitas.html">Registrar Cita</a></li>
            <li><a href="soporte.html">Soporte</a></li>
            <li><a href="logout.php">Cerrar sesión</a></li>
        </ul>
    </nav>
    <p>Todos los derechos reservados © Universidad Tecnologica de Panama 2024</p>
    <?php if (isset($_COOKIE['ultima_sesion'])): ?>
        <p>Última sesión: <?php echo htmlspecialchars($_COOKIE['ultima_sesion']); ?></p>
    <?php else: ?>
        <p>Bienvenido, esta es tu primera sesión.</p>
    <?php endif; ?>
</footer>
</body>
</html>
