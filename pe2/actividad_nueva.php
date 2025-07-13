<?php
session_start();
$tipo = $_SESSION['tipo'] ?? null;
if ($tipo !== 'admin') {
    header('Location: index.php');
    exit;
}

require_once 'actividades.class.inc.php';
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'nombre' => $_POST['nombre'] ?? '',
        'categoria' => $_POST['categoria'] ?? '',
        'modalidad' => $_POST['modalidad'] ?? '',
        'pistas' => $_POST['pistas'] ?? 0,
        'descripcion' => $_POST['descripcion'] ?? '',
        'imagen' => $_POST['imagen'] ?? ''
    ];

    try {
        Actividades::registrarActividad($datos);
        header('Location: actividades.php');
        exit;
    } catch (Exception $e) {
        $mensaje = "Error al crear la actividad: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <META NAME = "author" CONTENT = "Mabilia Stella Rinelli Padron">
        <META NAME = "description" CONTENT = "Documento de Alta Usuario del Club Deportivo">

        <title>Alta Usuario | Bounce Nation</title>
        
        <!-- Logo en la pestaña -->
        <link rel="icon" href="imagenes/logo_cuadrado.png" type="image/x-icon">
        
        <!-- Enlace a CSS -->
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/header_footer_style.css">
        <link rel="stylesheet" href="css/altausuarios_style.css">

    </head>
    <body>
        <header>
            <section class="top-header">
                <!-- Logo del club -->
                <a href="index.html">
                    <img src="imagenes/logo_extendido.png" alt="Logo Club Deportivo Bounce Nation" />
                </a>

                <!-- Formulario de inicio de sesión -->
                <form action="login.php" method="post">
                    <label for="username">Usuario:</label>
                    <input type="text" id="username" name="username" required>
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                    <button type="submit">Entrar</button>

                    <!-- Enlace para alta de usuarios -->
                    <a href="altausuarios.html" style="margin-left: 20px;">Nuevo Usuario</a>
                </form>

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
            <h2>Crear Nueva Actividad</h2>
            <?php if ($mensaje): ?>
                <p style="color:red;"><?= htmlspecialchars($mensaje) ?></p>
            <?php endif; ?>
            <form id="form-actividad" method="post">
                <label>Nombre: <input type="text" name="nombre"></label><br>
                <label>Categoría:
                    <select name="categoria">
                        <option value="">Selecciona una categoría</option>
                        <option value="Fútbol">Fútbol</option>
                        <option value="Baloncesto">Baloncesto</option>
                        <option value="Voleibol">Voleibol</option>
                        <option value="Béisbol">Béisbol</option>
                    </select>
                </label><br>
                <label>Modalidad: 
                    <select name="modalidad">
                        <option value="">Selecciona una modalidad</option>
                        <option value="Equipo">Equipo</option>
                        <option value="Individual">Individual</option>
                    </select>
                </label><br>
                <label>Pistas: <input type="text" name="pistas"></label><br>
                <label>Descripción:<br>
                    <textarea name="descripcion"></textarea>
                </label><br>
                <label>Imagen:
                    <select name="imagen">
                        <option value="">Selecciona una imagen</option>
                        <?php
                        $imagenes = glob('imagenes/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                        foreach ($imagenes as $img) {
                            $nombre = basename($img);
                            echo "<option value=\"imagenes/$nombre\">$nombre</option>";
                        }
                        ?>
                    </select>
                </label><br>
                <button type="submit">Crear</button>
                <a href="actividades.php">Cancelar</a>
                <section id="errores" style="color:red; margin-top:10px;"></section>
            </form>
        </main>
        <footer class="footer">
            <p>Desarrollado por Mabilia Stella Rinelli Padron</p>
            <p>Club Deportivo Bounce Nation</p>
            <ul>
                <li><a href="contacto.html">Contacto</a></li>
                <li><a href="como_se_hizo.pdf" target="_blank">Informe: Cómo se hizo</a></li>
            </ul>
        </footer>
        <script src="js/validar_nuevaAct.js"></script>
        <script src="js/mouse_follow.js"></script>
    </body>
</html>