<?php
namespace DaVinci\Models;

use DaVinci\DB\DBConnection;
use Exception;
use JsonSerializable;
use PDO;

class Post extends Modelo implements JsonSerializable
{
    protected $table = "posts";
    protected $pk = "id";
    protected $class = self::class;
    protected $id = null;
    protected $content = null;
    protected $created_at = null;
    protected $user_id = null;

    /** @var array Lista de los atributos que permitidos cargar en nuestra clase. */
    protected $atributosPermitidos = ['id', 'content', 'user_id', 'created_at'];

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'content' => $this->getContent(),
            'user_id' => $this->getUserId(),
            'created_at' => $this->getCreatedAt(),
        ];
    }

    public function massAssignament(array $data)
    {
        foreach($this->atributosPermitidos as $attr) {
            if(isset($data[$attr])) {
                $this->{$attr} = $data[$attr];
            }
        }
    }

    public function create(string $content, string $id)
    {
        $data = [];
     
        $data['content'] = $content;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['user_id'] = $id;
        
        $query = "INSERT INTO " . $this->table . " (";

        foreach($data as $prop => $value){

            $query .= " $prop,";
        }

        $query = substr($query, 0, -1);

        $query .= " ) VALUES (";

        foreach($data as $prop => $value){

            $query .= " :$prop,";
        }

        $query = substr($query, 0, -1);

        $query .= " );";

        $db = DBConnection::getConnection();
        
        $stmt = $db->prepare($query);
        $exito = $stmt->execute($data);

        if(!$exito) {
            throw new Exception('No se pudo crear el Registro');
        }
    }

    public function byUser($user_id)
    {
        $db = DBConnection::getConnection();

        $query = "SELECT posts.*, users.id AS user_id, users.user as users_user, users.name AS user_name, users.surname AS user_surname FROM posts LEFT JOIN users ON users.id=posts.user_id WHERE posts.user_id = ?";


        $stmt = $db->prepare($query);
        $stmt->execute([$user_id]);
  
        $salida = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            array_push($salida, $row);
        }         

        if(empty($salida)){
            echo json_encode([
                'success' => false,
                'errores' => 'El usuario no publico ningun posteo.'
            ]);
            die();
        }
        return $salida;
    }

    public function byId($id){

        $db = DBConnection::getConnection();

        $query = "SELECT posts.*, users.id AS user_id, users.user as users_user, users.name AS user_name, users.surname AS user_surname FROM posts LEFT JOIN users ON users.id=posts.user_id WHERE posts.id = ?";

        $stmt = $db->prepare($query);
        $stmt->execute([$id]);
  
        $salida = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$salida){
            echo json_encode([
                'success' => false,
                'errores' => 'El post no existe.'
            ]);
            die();
        }

        $post = new Post;
        $post->massAssignament($salida);
         

        return $salida;
    }

    
    public function delete(string $id, string $user_id){
        
        $db = DBConnection::getConnection();

        $query = "SELECT * FROM posts
                  WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$id]);

        if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
 
            if($row['user_id'] != $user_id){
                echo json_encode([
                    'success' => false,
                    'errores' => 'Solo podes eliminar publicaciones propias.'
                ]);
                die();
            }

            echo 'delete';
            die();
        }
        echo json_encode([
            'success' => false,
            'errores' => 'No existe el post id: '.$id.'.'
        ]);
        die();
    }

    public function edit(){}
    
    public function getAll(){
        $db = DBConnection::getConnection();

        $query = "SELECT posts.*, users.id AS user_id, users.user as users_user, users.name AS user_name, users.surname AS user_surname FROM posts LEFT JOIN users ON users.id = posts.user_id";
        $stmt = $db->prepare($query);
        $stmt->execute();
  
        $salida = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($salida, $row);
        }         

        if(empty($salida)){
            echo json_encode([
                'success' => false,
                'errores' => 'No existen posteos por el momento.'
            ]);
            die();
        }
        return $salida;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

      /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

       /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }


}
