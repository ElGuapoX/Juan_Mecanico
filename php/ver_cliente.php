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

// Validar el ID del cliente recibido
$id_cliente = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Obtener los datos del cliente
$query_cliente = "SELECT * FROM CLIENTE WHERE ID_CLIENTE = $id_cliente";
$result_cliente = $conn->query($query_cliente);
$cliente = null;

if ($result_cliente->num_rows > 0) {
    $cliente = $result_cliente->fetch_assoc();
} else {
    die("Cliente no encontrado.");
}

// Obtener los automóviles asociados al cliente
$query_autos = "SELECT * FROM AUTOMOVIL WHERE ID_CLIENTE = $id_cliente";
$result_autos = $conn->query($query_autos);

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Cliente</title>
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
            <a href="ver_calendario.php">Consultar Calendario de Citas</a>
            <a href="detalle_cliente.php">Lista de Clientes</a>
            <a href="ver_mecanicos.php">Lista de Mecánicos</a>
            <a href="../registromecanico.html">Registro de Mecánico</a>
            <a href="logout.php">Cerrar Sesión</a>
        </div>
    </div>
</header>
<h1>Detalles del Cliente</h1>
<main>
    <?php if ($cliente): ?>
        <p><strong>ID:</strong> <?php echo $cliente['ID_CLIENTE']; ?></p>
        <p><strong>Nombre:</strong> <?php echo $cliente['NOMBRE']; ?></p>
        <p><strong>Apellido:</strong> <?php echo $cliente['APELLIDO']; ?></p>
        <p><strong>Email:</strong> <?php echo $cliente['EMAIL']; ?></p>
        <p><strong>Teléfono:</strong> <?php echo $cliente['TELEFONO']; ?></p>
        <p><strong>Fecha de Creación:</strong> <?php echo $cliente['FECHA_CREACION']; ?></p>
        <p><strong>Última Sesión:</strong> <?php echo $cliente['ULTIMA_SESION']; ?></p>
        
        <h2>Automóviles Registrados</h2>
<?php if ($result_autos->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Modelo</th>
                <th>Matrícula</th>
                <th>Marca</th>
                <th>Color</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($auto = $result_autos->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $auto['ID_AUTOMOVIL']; ?></td>
                    <td><?php echo $auto['MODELO']; ?></td>
                    <td><?php echo $auto['MATRICULA']; ?></td>
                    <td><?php echo $auto['MARCA']; ?></td>
                    <td><?php echo $auto['COLOR'] ?: 'N/A'; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No se encontraron automóviles registrados para este cliente.</p>
<?php endif; ?>

<!-- Nuevo botón para registrar un automóvil -->
<a href="registrar_auto.php?id_cliente=<?php echo $id_cliente; ?>" class="btn">Registrar Nuevo Automóvil</a>

    <?php else: ?>
        <p>Cliente no encontrado.</p>
    <?php endif; ?>
    <a href="detalle_cliente.php" class="btn">Volver</a>
</main>

<li><a href="../admin.php">Inicio</a></li>
            <li><a href="../php/ver_calendario.php">Citas</a></li>
            <li><a href="../php/detalle_cliente.php">Clientes</a></li>
            <li><a href="../php/ver_mecanicos.php">Mecánicos</a></li>
            <li><a href="../registromecanico.html">Registro de Mecánico</a></li>
            <li><a href="../soporte.html">Soporte</a></li>
</body>
</html>
