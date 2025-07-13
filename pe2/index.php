<?php
session_start();
$usuario = $_SESSION['username'] ?? null;
$tipo = $_SESSION['tipo'] ?? null;

require_once 'actividades.class.inc.php';
list($actividades, $total) = Actividades::obtenerActividades(0, TAMANIO_PAGINA, 'id'); // 0 = inicio, 10 = cantidad, 'id' = orden
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
        <link rel="stylesheet" href="css/index_style.css">
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
        <main>
            <section class="club-info">
                <h1 id="titulo">Club Deportivo Bounce Nation</h1>
                <p>
                    Hace más de una década, Bounce Nation nació con un propósito claro: introducir el béisbol en nuestra ciudad y crear un espacio donde la pasión por el deporte pudiera crecer y unir a la comunidad. Lo que comenzó como un terreno dedicado exclusivamente a este deporte, pronto se convirtió en mucho más.
                    <br><br>Hoy, Bounce Nation es un club deportivo integral, abierto a personas de todas las edades y niveles, que ofrece espacios especialmente acondicionados para la práctica de béisbol, baloncesto, voleibol y fútbol. Nuestro compromiso con el desarrollo deportivo nos ha llevado a crear un ambiente seguro, dinámico y motivador donde cada jugador puede entrenar, competir y disfrutar al máximo.
                    <br><br>Nos enorgullece ser un punto de encuentro para deportistas, familias y amantes de un estilo de vida activo. Ya seas principiante, jugador experimentado o simplemente alguien que disfruta del deporte, Bounce Nation es tu lugar.
                    <br><br><strong>¡Te esperamos para que vivas la experiencia deportiva al máximo!</strong><br><br>
                </p>
            </section>
            <section class="zona-beige">
                <header>
                    <h3>Actividades destacadas</h3>
                </header>
                <section id="carrusel-actividades" class="carrusel-actividades">
                    <a id="actividad-link" href="#" target="_blank">
                        <article class="carrusel-fondo">
                            <section class="carrusel-info">
                                <h3 id="actividad-titulo"></h3>
                                <p id="actividad-modalidad"></p>
                                <p id="actividad-pistas"></p>
                            </section>
                        </article>
                    </a>
                    <nav class="carrusel-controles" aria-label="Controles del carrusel">
                        <button type="button" id="flecha-izq" class="flecha-carrusel" aria-label="Anterior">
                            &#8592; Anterior
                        </button>
                        <button type="button" id="flecha-der" class="flecha-carrusel" aria-label="Siguiente">
                            Siguiente &#8594;
                        </button>
                    </nav>
                </section>
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
        <script>
            window.actividades = <?php
            echo json_encode(array_map(function($act) {
                return [
                    'id' => $act->get('id'),
                    'nombre' => $act->get('nombre'),
                    'modalidad' => $act->get('modalidad'),
                    'pistas' => $act->get('pistas'),
                    'imagen' => $act->get('imagen')
                ];
            }, $actividades));
            ?>;
        </script>
        <script src="js/carrusel.js"></script>
        <script src="js/mouse_follow.js"></script>
        <script src="js/animacion_titulo.js"></script>
    </body>
</html>