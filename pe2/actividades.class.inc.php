<?php
require_once 'datosObject.class.inc.php';

class Actividades extends DatosObject {
    /**
     * Clase para manejar las actividades en la base de datos.
     * Hereda de DatosObject para manejar la conexión a la base de datos.
     */
    protected $datos = array(
        "id" => "",
        "nombre" => "",
        "modalidad" => "",
        "pistas" => "",
        "descripcion" => "",
        "imagen" => "",
        "categoria" => ""
    );

    public function __construct($datos = array()) {
        foreach ($datos as $campo => $valor) {
            if (array_key_exists($campo, $this->datos)) {
                $this->datos[$campo] = $valor;
            }
        }
    }

    /**
     * Obtiene una actividad por su ID.
     *
     * @param int $id ID de la actividad.
     * @return Actividades|null
     */
    public static function obtenerActividad($id) {
        $conexion = parent::conectar();
        $sql = "SELECT * FROM " . TABLA_ACTIVIDADES . " WHERE id = :id";
        try {
            $st = $conexion->prepare($sql);
            $st->bindValue(":id", $id, PDO::PARAM_INT);
            $st->execute();
            $fila = $st->fetch();
            parent::desconectar();
            return $fila ? new self($fila) : null;
        } catch (PDOException $e) {
            parent::desconectar();
            die("Error al obtener actividad: " . $e->getMessage());
        }
    }

    /**
     * Obtiene actividades paginadas.
     *
     * @param int $filaInicio Fila de inicio.
     * @param int $numeroFilas Número de filas a obtener.
     * @param string $orden Campo por el que ordenar.
     * @return array [array $actividades, int $total]
     */
    public static function obtenerActividades($filaInicio, $numeroFilas, $orden) {
        $conexion = parent::conectar();
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . TABLA_ACTIVIDADES . " ORDER BY $orden LIMIT :filaInicio, :numeroFilas";
        try {
            $st = $conexion->prepare($sql);
            $st->bindValue(":filaInicio", $filaInicio, PDO::PARAM_INT);
            $st->bindValue(":numeroFilas", $numeroFilas, PDO::PARAM_INT);
            $st->execute();
            $actividades = array();
            foreach ($st->fetchAll() as $fila) {
                $actividades[] = new self($fila);
            }
            $st = $conexion->query("SELECT found_rows() AS total");
            $fila = $st->fetch();
            parent::desconectar();
            return array($actividades, $fila["total"]);
        } catch (PDOException $e) {
            parent::desconectar();
            die("Error al obtener actividades: " . $e->getMessage());
        }
    }

    /**
     * Obtiene todas las actividades.
     *
     * @return array
     */
    public static function obtenerTodas() {
        $conexion = parent::conectar();
        $sql = "SELECT * FROM " . TABLA_ACTIVIDADES . " ORDER BY categoria, nombre";
        $st = $conexion->prepare($sql);
        $st->execute();
        $actividades = $st->fetchAll(PDO::FETCH_ASSOC);
        parent::desconectar();
        return $actividades;
    }

    /**
     * Obtiene el valor de un campo de la actividad.
     *
     * Permite acceder de forma segura a los datos protegidos de la actividad.
     *
     * @param string $campo Nombre del campo a obtener (por ejemplo: 'nombre', 'modalidad', etc.).
     * @return mixed|null Valor del campo si existe, o null si no existe.
     */
    public function get($campo) {
        return $this->datos[$campo] ?? null;
    }
    
    /**
     * Registra una nueva actividad en la base de datos.
     *
     * @param array $datos Datos de la actividad.
     * @return void
     */
    public static function registrarActividad($datos) {
        $conexion = parent::conectar();
        $sql = "INSERT INTO " . TABLA_ACTIVIDADES . " (nombre, modalidad, pistas, descripcion, imagen, categoria)
                VALUES (:nombre, :modalidad, :pistas, :descripcion, :imagen, :categoria)";
        try {
            $st = $conexion->prepare($sql);
            $st->bindValue(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $st->bindValue(":modalidad", $datos["modalidad"], PDO::PARAM_STR);
            $st->bindValue(":pistas", $datos["pistas"], PDO::PARAM_INT);
            $st->bindValue(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
            $st->bindValue(":imagen", $datos["imagen"], PDO::PARAM_STR);
            $st->bindValue(":categoria", $datos["categoria"], PDO::PARAM_STR);
            $st->execute();
            parent::desconectar();
            header("Location: actividades.php");
            exit;
        } catch (PDOException $e) {
            parent::desconectar();
            die("Error al registrar actividad: " . $e->getMessage());
        }
    }

    /**
     * Edita los datos de una actividad existente.
     *
     * @param array $datos Nuevos datos de la actividad 
     * @return void
     */
    public static function editarActividad($datos) {
        $conexion = parent::conectar();
        $sql = "UPDATE " . TABLA_ACTIVIDADES . " 
                SET nombre = :nombre, modalidad = :modalidad, pistas = :pistas, descripcion = :descripcion, imagen = :imagen, categoria = :categoria
                WHERE id = :id";
        try {
            $st = $conexion->prepare($sql);
            $st->bindValue(":nombre", $datos["nombre"], PDO::PARAM_STR);
            $st->bindValue(":modalidad", $datos["modalidad"], PDO::PARAM_STR);
            $st->bindValue(":pistas", $datos["pistas"], PDO::PARAM_INT);
            $st->bindValue(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
            $st->bindValue(":imagen", $datos["imagen"], PDO::PARAM_STR);
            $st->bindValue(":categoria", $datos["categoria"], PDO::PARAM_STR);
            $st->bindValue(":id", $datos["id"], PDO::PARAM_INT);
            $st->execute();
            parent::desconectar();
            header("Location: actividades.php");
            exit;
        } catch (PDOException $e) {
            parent::desconectar();
            die("Error al editar actividad: " . $e->getMessage());
        }
    }
    
    /**
     * Elimina una actividad por su ID.
     *
     * @param int $id ID de la actividad a eliminar.
     * @return void
     */
    public static function eliminarActividad($id) {
        $conexion = parent::conectar();
        $sql = "DELETE FROM " . TABLA_ACTIVIDADES . " WHERE id = :id";
        try {
            $st = $conexion->prepare($sql);
            $st->bindValue(":id", $id, PDO::PARAM_INT);
            $st->execute();
            parent::desconectar();
            header("Location: actividades.php");
            exit;
        } catch (PDOException $e) {
            parent::desconectar();
            die("Error al eliminar actividad: " . $e->getMessage());
        }
    }
}
?>