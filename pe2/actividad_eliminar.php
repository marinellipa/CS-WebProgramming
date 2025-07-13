<?php
session_start();
$tipo = $_SESSION['tipo'] ?? null;
if ($tipo !== 'admin') {
    header('Location: index.php');
    exit;
}

require_once 'actividades.class.inc.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: actividades.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        Actividades::eliminarActividad($id);
        header('Location: actividades.php');
        exit;
    } catch (Exception $e) {
        $mensaje = "Error al eliminar la actividad: " . $e->getMessage();
    }
} else {
    $actividad = Actividades::obtenerActividad($id);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Actividad</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <main>
        <h2>Eliminar Actividad</h2>
        <?php if (!empty($mensaje)): ?>
            <p style="color:red;"><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>
        <?php if (!empty($actividad)): ?>
            <p>¿Seguro que deseas eliminar la actividad <strong><?= htmlspecialchars($actividad->get('nombre')) ?></strong>?</p>
            <form method="post">
                <button type="submit">Sí, eliminar</button>
                <a href="actividades.php">Cancelar</a>
            </form>
        <?php endif; ?>
    </main>
    <script src="js/mouse_follow.js"></script>
</body>
</html>