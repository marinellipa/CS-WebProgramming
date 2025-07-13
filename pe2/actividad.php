<?php
session_start();
require_once 'actividades.class.inc.php';

$usuario = $_SESSION['username'] ?? null;
$tipo = $_SESSION['tipo'] ?? null;

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: actividades.php');
    exit;
}

$actividad = Actividades::obtenerActividad($id);
if (!$actividad) {
    echo "<h2>Actividad no encontrada</h2>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($actividad->get('nombre')) ?> | Bounce Nation</title>
    <link rel="icon" href="imagenes/logo_cuadrado.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/header_footer_style.css">
</head>
<body>
    <header>
        <section class="top-header">
            <a href="index.php">
                <img src="imagenes/logo_extendido.png" alt="Logo Club Deportivo Bounce Nation" />
            </a>
            <?php if (!$usuario): ?>
            <!-- Formulario de inicio de sesión -->
            <form action="login.php" method="post" style="display:inline;">
                <label for="username">Usuario:</label>
                <input type="text" id="username" name="username">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password">
                <button type="submit">Entrar</button>
                <a href="altausuarios.html" style="margin-left: 20px;">Nuevo Usuario</a>
            </form>
            <?php else: ?>
            <section style="float:right;">
                <span>Hola, <strong><?= htmlspecialchars($usuario); ?></strong> (<?= htmlspecialchars($tipo); ?>)</span>
                <a class="cerrar-sesion" href="logout.php" style="margin-left: 20px;">Cerrar sesión</a>
            </section>
            <?php endif; ?>
        </section>
        <nav>
            <ul style="list-style: none; padding: 0; display: flex; gap: 15px;">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="actividades.php">Actividades</a></li>
                <li><a href="conoce_club.html">Conoce Nuestro Club</a></li>
                <li><a href="eventos.html">Eventos Deportivos</a></li>
                <li><a href="informacion.html">Información General</a></li>
                <li><a href="sugerencias.html">Sugerencias</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2><?= htmlspecialchars($actividad->get('nombre')) ?></h2>
        <p><strong>Categoría:</strong> <?= htmlspecialchars($actividad->get('categoria')) ?></p>
        <p><strong>Modalidad:</strong> <?= htmlspecialchars($actividad->get('modalidad')) ?></p>
        <p><strong>Pistas:</strong> <?= htmlspecialchars($actividad->get('pistas')) ?></p>
        <p><strong>Descripción:</strong> <?= nl2br(htmlspecialchars($actividad->get('descripcion'))) ?></p>
        <?php if ($actividad->get('imagen')): ?>
            <img src="<?= htmlspecialchars($actividad->get('imagen')) ?>" alt="<?= htmlspecialchars($actividad->get('nombre')) ?>" style="max-width:400px;">
        <?php endif; ?>
        <br>
        <a href="actividades.php">← Volver a actividades</a>
    </main>
    <footer class="footer">
        <p>Desarrollado por Mabilia Stella Rinelli Padron</p>
        <p>Club Deportivo Bounce Nation</p>
        <ul>
            <li><a href="contacto.html">Contacto</a></li>
            <li><a href="como_se_hizo.pdf" target="_blank">Informe: Cómo se hizo</a></li>
        </ul>
    </footer>
    <script src="js/mouse_follow.js"></script>
</body>
</html>