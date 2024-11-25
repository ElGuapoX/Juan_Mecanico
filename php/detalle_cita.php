<?php
session_start();
include_once 'db.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html"); 
    exit();
}

$db = new Database();
$conn = $db->connect();

$id_cliente = $_GET['id_cliente']; // Obtener el ID del cliente desde la URL

// Realizamos un JOIN con la tabla CLIENTE para obtener el nombre y apellido
$query_cliente = "
    SELECT C.ID_CLIENTE, C.nombre, C.apellido, CT.FECHA_SOLICITUD, CT.HORA
    FROM CITA CT
    JOIN CLIENTE C ON CT.ID_CLIENTE = C.ID_CLIENTE
    WHERE C.ID_CLIENTE = $id_cliente
";

$result_cliente = $conn->query($query_cliente);
$cliente = null;

if ($result_cliente->num_rows > 0) {
    $cliente = $result_cliente->fetch_assoc();
} else {
    echo "No se encontró el cliente.";
}

// Consulta para obtener los autos del cliente
$query_autos = "
    SELECT A.MODELO, A.MATRICULA, A.MARCA, A.COLOR
    FROM AUTOMOVIL A
    WHERE A.ID_CLIENTE = $id_cliente
";

$result_autos = $conn->query($query_autos);
$autos = [];

if ($result_autos->num_rows > 0) {
    while ($row = $result_autos->fetch_assoc()) {
        $autos[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Cita - Juan Mecanico</title>
    <link rel="stylesheet" href="/Universidad/juan_mecanico/css/styles.css">
</head>
<body>
<header>
    <div class="header-content">
        <a href="../admin.php"><img src="/Universidad/juan_mecanico/images/con_fondo-removebg-preview (1).png" alt="Logo Juan Mecanico" class="logo"></a>
        <div class="contact-info">Contactanos: 1234-5678  /  5678-1234</div>
        <div class="hours">Horario de atención: lunes a sábado de 8:00 am a 6:00 pm</div>
    </div>
    <div class="dropdown">
        <button class="dropbtn">&#9776; Opciones</button>
        <div class="dropdown-content">
                <a href="../admin.php">Inicio</a>
                <a href="../php/detalle_cliente.php">Lista de Clientes</a>
                <a href="../php/ver_mecanicos.php">Lista de Mecánicos</a>
                <a href="../registroauto.html">Registrar Nuevo Auto</a>
                <a href="../php/ver_calendario.php">Consultar Calendario de Citas</a>
                <a href="logout.php">Cerrar Sesión</a>
        </div>
    </div>
</header>

<main>
    <h2>Detalles de la Cita</h2>
    
    <?php if ($cliente): ?>
        <p><strong>Cliente:</strong> <?php echo $cliente['nombre'] . " " . $cliente['apellido']; ?></p>
        <p><strong>Fecha de Solicitud:</strong> <?php echo $cliente['FECHA_SOLICITUD']; ?></p>
        <p><strong>Hora de la Cita:</strong> <?php echo $cliente['HORA']; ?></p>

        <h3>Autos del Cliente</h3>
        <?php if (count($autos) > 0): ?>
            <ul>
                <?php foreach ($autos as $auto): ?>
                    <li>
                        <strong>Marca:</strong> <?php echo $auto['MARCA']; ?><br>
                        <strong>Modelo:</strong> <?php echo $auto['MODELO']; ?><br>
                        <strong>Matrícula:</strong> <?php echo $auto['MATRICULA']; ?><br>
                        <strong>Color:</strong> <?php echo $auto['COLOR']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No hay autos registrados para este cliente.</p>
        <?php endif; ?>
    <?php endif; ?>
</main>

<footer>
    <nav class="main-nav">
        <ul>
        <li><a href="../admin.php">Inicio</a></li>
            <li><a href="../php/ver_calendario.php">Citas</a></li>
            <li><a href="../php/detalle_cliente.php">Clientes</a></li>
            <li><a href="../php/ver_mecanicos.php">Mecánicos</a></li>
            <li><a href="../registromecanico.html">Registro de Mecánico</a></li>
            <li><a href="../soporte.html">Soporte</a></li>
        </ul>
    </nav>
    <p>Todos los derechos reservados © Universidad Tecnologica de Panama 2024</p>
</footer>

</body>
</html>