<?php
session_start();
include_once 'db.php';
// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html"); 
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar el formulario enviado
    $id_cliente = (int) $_POST['id_cliente'];
    $modelo = $_POST['modelo'];
    $matricula = $_POST['matricula'];
    $marca = $_POST['marca'];
    $color = $_POST['color'] ?: null;

    $db = new Database();
    $conn = $db->connect();

    $query = "INSERT INTO AUTOMOVIL (ID_CLIENTE, MODELO, MATRICULA, MARCA, COLOR) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issss", $id_cliente, $modelo, $matricula, $marca, $color);

    if ($stmt->execute()) {
        header("Location: detalle_cliente.php?id=$id_cliente");
        exit;
    } else {
        $error = "Error al registrar el automóvil: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    // Mostrar el formulario
    $id_cliente = isset($_GET['id_cliente']) ? (int)$_GET['id_cliente'] : 0;
    if ($id_cliente === 0) {
        die("ID de cliente no válido.");
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Automóvil</title>
    <link rel="stylesheet" href="/Universidad/juan_mecanico/css/styles.css">
</head>
<body class="fondo-registroauto">
<header>
    <h1>Registrar Automóvil</h1>
</header>
<main>
    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="registrar_auto.php" method="POST">
        <input type="hidden" name="id_cliente" value="<?php echo $id_cliente; ?>">
        
        <label for="modelo">Modelo:</label>
        <input type="text" id="modelo" name="modelo" required>
        
        <label for="matricula">Matrícula:</label>
        <input type="text" id="matricula" name="matricula" required>
        
        <label for="marca">Marca:</label>
        <input type="text" id="marca" name="marca" required>
        
        <label for="color">Color:</label>
        <input type="text" id="color" name="color">
        
        <button type="submit">Registrar Automóvil</button>
    </form>
    <a href="detalle_cliente.php?id=<?php echo $id_cliente; ?>" class="btn">Cancelar</a>
</main>
</body>
</html>
