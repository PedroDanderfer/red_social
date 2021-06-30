<?php
namespace DaVinci\Models;

use DaVinci\DB\DBConnection;
use JsonSerializable;
use PDO;

/**
 * Class Modelo
 *
 * Clase de base para todas las clases que vayan a mapearse contra una tabla de SQL.
 */
class Modelo
{
    /** @var string La tabla contra la que mapea la clase. */
    protected $table;
    /** @var string La primary key. */
    protected $pk;
    /** @var array Lista de los atributos permitidos para "asignación masiva", usado en el alta y el editar. */
    protected $atributosPermitidos = [];

    // public function jsonSerialize()
    // {
    //     return [
    //     ];
    // }
    /**
     * Retorna todos los registros de la clase.
     *
     * @return array|static[]
     */
    public function todos()
    {
        $db = DBConnection::getConnection();
        $query = "SELECT * FROM " . $this->table;

        $stmt = $db->prepare($query);
        $stmt->execute();

        // self hace referencia a la clase en la que estoy ahora. Es decir la clase donde el self está escrito.
        // En este caso, el self no nos sirve, porque no queremos instancias de ESTA clase, sino de las clases
        // que hereden de Modelo.
        // Si quiero obtener el nombre de la clase que está EJECUTANDO este método, puedo hacerlo de dos maneras:
        // 1. get_class($this)
        //  Esa función retorna un string con el nombre de la clase del objeto que le pasamos como argumento.
        //  La única limitación es que solo funciona para métodos no static.
        // 2. Reemplazar "self" con "static".
        //  static, usada en este contexto como reemplazo de un nombre de clase, es similar a self, con la
        //  diferencia de que hace referencia a la clase que EJECUTA el método.
//        return  $stmt->fetchAll(PDO::FETCH_CLASS, get_class($this));
//        
//        
//        
        return  $stmt->fetchAll(PDO::FETCH_CLASS, self::class);
        // 
        // 
        // 
        // 
        // 

//        $salida = [];

//        while($fila = $stmt->fetchObject(self::class)) {
//            $salida[] = $fila;
//        }

//        return $salida;
//        
//        
//        
//        
//        
      
    }

    /**
     * Obtiene un registro en base a la pk provista.
     *
     * @param $pk
     * @return null|static
     */
    public function getByPk($pk)
    {
        $db = DBConnection::getConnection();

        $query = "SELECT * FROM " . $this->table . "
                  WHERE " . $this->pk . " = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$pk]);

        if($obj = $stmt->fetchObject(static::class)) {
            return $obj;
        }
        return null;
    }

    /**
     * Elimina el registro de la base de datos.
     *
     * @param int $pk
     * @return bool
     * @throws \Exception
     */
    public function eliminar($pk)
    {
        $db = DBConnection::getConnection();
        $query = "DELETE FROM " . $this->table . "
                    WHERE " . $this->pk . " = ?";

        $stmt = $db->prepare($query);
        $exito = $stmt->execute([$pk]);

        if(!$exito) {
            throw new \Exception('El registro no pudo ser eliminado.');
        }

        return true;
    }
}
