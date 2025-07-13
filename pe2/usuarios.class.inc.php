<?php
require_once 'datosObject.class.inc.php';

class Usuarios extends DatosObject {
    /**
     * Clase Usuarios para manejar la autenticación y registro de usuarios.
     * Extiende la clase DatosObject para manejar la conexión a la base de datos.
     */

    protected $datos = array(
        "id" => "",
        "nombre" => "",
        "apellido" => "",
        "email" => "",
        "telefono" => "",
        "fecha_nacimiento" => "",
        "direccion" => "",
        "conocer" => "",
        "username" => "",
        "password" => "",
        "tipo" => ""
    );

    public function __construct($datos = array()) {
        foreach ($datos as $campo => $valor) {
            if (array_key_exists($campo, $this->datos)) {
                $this->datos[$campo] = $valor;
            }
        }
    }

    /**
     * Inicia sesión para un usuario existente.
     *
     * Busca el usuario por nombre de usuario y verifica la contraseña.
     * Si la autenticación es exitosa, inicia la sesión y redirige a 'index.php'.
     * Si falla, muestra un mensaje de error y un enlace para volver.
     *
     * @param string $username Nombre de usuario.
     * @param string $user_password Contraseña proporcionada por el usuario.
     * @return void
     */
    public static function loginUsuario($username, $user_password) {
        $conexion = parent::conectar();
        $sql = "SELECT * FROM " . TABLA_USUARIOS . " WHERE username = :username";
        try {
            $st = $conexion->prepare($sql);
            $st->bindValue(":username", $username, PDO::PARAM_STR);
            $st->execute();
            $fila = $st->fetch();
            parent::desconectar();
            if ($fila && password_verify($user_password, $fila["password"])) {
                session_start();
                $_SESSION['username'] = $fila['username'];
                $_SESSION['tipo'] = $fila['tipo'];
                header("Location: index.php");
                exit;
            } else {
                echo "Usuario o contraseña incorrectos. <a href='index.php'>Volver</a>";
            }
        } catch (PDOException $e) {
            parent::desconectar();
            die("Error en login: " . $e->getMessage());
        }
    }

    /**
     * Registra un nuevo usuario en la base de datos.
     *
     * Inserta un nuevo registro en la tabla 'usuarios' con los datos proporcionados.
     * La contraseña se almacena de forma segura usando hash.
     * Si la inserción es exitosa, redirige a 'alta_exito.html'.
     * Si ocurre un error, muestra un mensaje de error.
     *
     * @param string $nombre Nombre del usuario.
     * @param string $apellido Apellido del usuario.
     * @param string $email Correo electrónico del usuario.
     * @param string $telefono Teléfono del usuario.
     * @param string $fecha_nacimiento Fecha de nacimiento del usuario (YYYY-MM-DD).
     * @param string $direccion Dirección del usuario.
     * @param string $conocer Cómo conoció el sitio.
     * @param string $username Nombre de usuario.
     * @param string $password Contraseña del usuario (será hasheada antes de guardar).
     * @return void
     */
    public static function registrarUsuario($datos) {
        $conexion = parent::conectar();
        $sql = "INSERT INTO " . TABLA_USUARIOS . " (nombre, apellido, email, telefono, fecha_nacimiento, direccion, conocer, username, password)
                VALUES (:nombre, :apellido, :email, :telefono, :fecha_nacimiento, :direccion, :conocer, :username, :password)";
        try {
            $st = $conexion->prepare($sql);
            $st->bindValue(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $st->bindValue(":apellido", $datos["apellido"], PDO::PARAM_STR);
            $st->bindValue(":email", $datos["email"], PDO::PARAM_STR);
            $st->bindValue(":telefono", $datos["telefono"], PDO::PARAM_STR);
            $st->bindValue(":fecha_nacimiento", $datos["fecha_nacimiento"], PDO::PARAM_STR);
            $st->bindValue(":direccion", $datos["direccion"], PDO::PARAM_STR);
            $st->bindValue(":conocer", $datos["conocer"], PDO::PARAM_STR);
            $st->bindValue(":username", $datos["username"], PDO::PARAM_STR);
            $st->bindValue(":password", password_hash($datos["password"], PASSWORD_DEFAULT), PDO::PARAM_STR);
            $st->execute();
            parent::desconectar();
            header("Location: alta_exito.html");
            exit;
        } catch (PDOException $e) {
            parent::desconectar();
            die("Error al registrar usuario: " . $e->getMessage());
        }
    }
}
?>