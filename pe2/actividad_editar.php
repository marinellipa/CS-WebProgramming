<?php
session_start();
$tipo = $_SESSION['tipo'] ?? null;
if ($tipo !== 'admin') {
    header('Location: index.php');
    exit;
}

require_once 'actividades.class.inc.php';

$id = $_GET['id'] ?? null;
$mensaje = '';

if (!$id) {
    header('Location: actividades.php');
    exit;
}

$actividad = Actividades::obtenerActividad($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'id' => $id,
        'nombre' => $_POST['nombre'] ?? '',
        'categoria' => $_POST['categoria'] ?? '',
        'modalidad' => $_POST['modalidad'] ?? '',
        'pistas' => $_POST['pistas'] ?? 0,
        'descripcion' => $_POST['descripcion'] ?? '',
        'imagen' => $_POST['imagen'] ?? ''
    ];
    try {
        Actividades::editarActividad($datos);
        header('Location: actividades.php');
        exit;
    } catch (Exception $e) {
        $mensaje = "Error al actualizar la actividad: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Actividad</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <main>
        <h2>Editar Actividad</h2>
        <?php if ($mensaje): ?>
            <p style="color:red;"><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>
        <section id="errores" aria-live="polite" style="color:red; margin-bottom:10px;"></section>
        <form method="post">
            <label>Nombre: <input type="text" name="nombre" value="<?= htmlspecialchars($actividad->get('nombre')) ?>"></label><br>
            <label>Categoría:
                <select name="categoria">
                    <option value="Fútbol" <?= $actividad->get('categoria') == 'Fútbol' ? 'selected' : '' ?>>Fútbol</option>
                    <option value="Baloncesto" <?= $actividad->get('categoria') == 'Baloncesto' ? 'selected' : '' ?>>Baloncesto</option>
                    <option value="Voleibol" <?= $actividad->get('categoria') == 'Voleibol' ? 'selected' : '' ?>>Voleibol</option>
                    <option value="Béisbol" <?= $actividad->get('categoria') == 'Béisbol' ? 'selected' : '' ?>>Béisbol</option>
                </select>
            </label><br>
            <label>Modalidad: 
                <select name="modalidad">
                    <option value="Equipo" <?= $actividad->get('modalidad') == 'Equipo' ? 'selected' : '' ?>>Equipo</option>
                    <option value="Individual" <?= $actividad->get('modalidad') == 'Individual' ? 'selected' : '' ?>>Individual</option>
                </select>
            </label><br>
            <label>Pistas: <input type="text" name="pistas" value="<?= htmlspecialchars($actividad->get('pistas')) ?>"></label><br>
            <label>Descripción:<br>
                <textarea name="descripcion"><?= htmlspecialchars($actividad->get('descripcion')) ?></textarea>
            </label><br>
            <label>Imagen:
                <select name="imagen">
                    <?php
                    $imagenes = glob('imagenes/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                    foreach ($imagenes as $img) {
                        $nombre = basename($img);
                        $selected = ($actividad->get('imagen') == "imagenes/$nombre") ? 'selected' : '';
                        echo "<option value=\"imagenes/$nombre\" $selected>$nombre</option>";
                    }
                    ?>
                </select>
            </label><br>
            <button type="submit">Guardar cambios</button>
            <a href="actividades.php">Cancelar</a>
        </form>
    </main>
    <script src="js/validar_editarAct.js"></script>
    <script src="js/mouse_follow.js"></script>
</body>
</html>