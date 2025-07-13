<?php
session_start();
$usuario = $_SESSION['username'] ?? null;
$tipo = $_SESSION['tipo'] ?? null;
$es_admin = ($tipo === 'admin'); 

require_once 'actividades.class.inc.php';

// Paginación
$por_pagina = TAMANIO_PAGINA; // Definido en configuracion.inc.php
$pagina = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$inicio = ($pagina - 1) * $por_pagina;

// Obtener actividades paginadas
list($result, $total_actividades) = Actividades::obtenerActividades($inicio, $por_pagina, 'id');

$total_paginas = ceil($total_actividades / $por_pagina);

// Menú dinámico por categorías
$menu = [];
foreach (Actividades::obtenerTodas() as $act) {
    $menu[$act['categoria']][] = $act;
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Mabilia Stella Rinelli Padron">
        <meta name="description" content="Documento Principal del Club Deportivo">
        <title>Bounce Nation | Club Deportivo</title>
        <link rel="icon" href="imagenes/logo_cuadrado.png" type="image/x-icon">
        <link rel="stylesheet" href="css/header_footer_style.css"> 
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/actividades_style.css">
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
                    <input type="text" id="username" name="username" required>
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                    <button type="submit">Entrar</button>
                    <a href="altausuarios.html" style="margin-left: 20px;">Nuevo Usuario</a>
                </form>
                <?php else: ?>
                <section style="float:right;">
                    <span>Hola, <strong><?php echo htmlspecialchars($usuario); ?></strong> (<?php echo htmlspecialchars($tipo); ?>)</span>
                    <a class="cerrar-sesion" href="logout.php" style="margin-left: 20px;">Cerrar sesión</a>
                </section>
                <?php endif; ?>
            </section>
            <!-- Menu de navegacion -->
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

        <main class="contenido">
            <aside class="menu-lateral">
                <h3 id="titulo">Menú de Actividades</h3>
                <?php foreach ($menu as $categoria => $acts): ?>
                    <strong><?= htmlspecialchars($categoria) ?></strong>
                    <ul>
                        <?php foreach ($acts as $act): ?>
                            <li>
                                <a href="actividad.php?id=<?= htmlspecialchars($act['id']) ?>">
                                    <?= htmlspecialchars($act['nombre']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endforeach; ?>
            </aside>
            <section class="contenido-principal">
                <h2>Actividades</h2>
                <?php if ($es_admin): ?>
                    <a href="actividad_nueva.php" class="btn-nueva">Crear nueva actividad</a>
                <?php endif; ?>
                <section class="actividades-grid">
                    <?php foreach($result as $act): ?>
                        <article class="actividad">
                            <h3>
                                <a href="actividad.php?id=<?= htmlspecialchars($act->get('id')) ?>">
                                    <?= htmlspecialchars($act->get('nombre')) ?>
                                </a>
                            </h3>
                            <p><strong>Modalidad:</strong> <?= htmlspecialchars($act->get('modalidad')) ?></p>
                            <p><strong>Pistas:</strong> <?= htmlspecialchars($act->get('pistas')) ?></p>
                            <?php if ($es_admin): ?>
                                <a href="actividad_editar.php?id=<?= $act->get('id') ?>">Editar</a>
                                <a href="actividad_eliminar.php?id=<?= $act->get('id') ?>" onclick="return confirm('¿Seguro que deseas eliminar?')">Eliminar</a>
                            <?php endif; ?>
                        </article>
                    <?php endforeach; ?>
                </section>
                <!-- Paginación -->
                <nav class="paginacion">
                    <?php if ($pagina > 1): ?>
                        <a href="?pagina=<?= $pagina-1 ?>">← Anterior</a>
                    <?php endif; ?>
                    <?php if ($pagina < $total_paginas): ?>
                        <a href="?pagina=<?= $pagina+1 ?>">Siguiente →</a>
                    <?php endif; ?>
                </nav>
            </section>
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
        <script src="js/animacion_titulo.js"></script>
    </body>
</html>