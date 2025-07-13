<?php
require_once 'configuracion.inc.php';
$dsn = DB_DSN;
$db_usuario = DB_USUARIO;
$db_contrasenia = DB_CONTRASENIA;

abstract class DatosObject {
    /**
     * Clase abstracta para manejar la conexión a la base de datos.
     */
    private static $conn = null;
    
    public function __construct(){}

    /**
     * Conecta a la base de datos usando las constantes de configuración.
     * @return PDO
     */
    protected static function conectar() {
        if (self::$conn === null) {
            try {
                self::$conn = new PDO(DB_DSN, DB_USUARIO, DB_CONTRASENIA);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conn->setAttribute(PDO::ATTR_PERSISTENT, true);
            } catch (PDOException $e) {
                die("Error de conexión: " . $e->getMessage());
            }
        }
        return self::$conn;
    }

    /**
     * Desconecta la base de datos.
     */
    public static function desconectar() {
        self::$conn = null;
    }
}
?>