<?php
namespace DaVinci\Models;

use DaVinci\DB\DBConnection;
use Exception;
use JsonSerializable;
use PDO;

class User extends Modelo implements JsonSerializable
{
    protected $table = "users";
    protected $pk = "id";
    protected $class = self::class;
    protected $id = null;
    protected $user = null;
    protected $name = null;
    protected $surname = null;
    protected $email = null;
    protected $password = null;
    protected $biography = null;
    protected $created_at = null;

    /** @var array Lista de los atributos que permitidos cargar en nuestra clase. */
    protected $atributosPermitidos = ['id', 'user', 'name', 'surname', 'email', 'password', 'biography', 'created_at'];

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'user' => $this->getUser(),
            'name' => $this->getName(),
            'surname' => $this->getSurname(),
            'email' => $this->getEmail(),
            'password' => $this->getPassword(),
            'biography' => $this->getBiography(),
            'created_at' => $this->getCreatedAt(),
        ];
    }




    /**
     * Devuelve los datos del usuario en base al $email provisto.
     *
     * @param $email
     * @return null|User
     */
    public function getByEmail($email)
    {
        $db = DBConnection::getConnection();

        $query = "SELECT * FROM users
                  WHERE email = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$email]);

        if($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
 
            $user = new self;
            $user->id = $row['id'];
            $user->user = $row['user'];
            $user->name = $row['name'];
            $user->surname = $row['surname'];
            $user->email = $row['email'];
            $user->password = $row['password'];
            $user->biography = $row['biography'];
            $user->created_at = $row['created_at'];

            return $user;
        }
        return null;
    }

    public function buscarValorUnico($valor, $campo)
    {
        $db = DBConnection::getConnection();

        $query = "SELECT * FROM users WHERE ". $campo . "=?";

        $stmt = $db->prepare($query);

        $stmt->execute([$valor]);

        $dato = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($dato)
            throw new Exception("El " . $campo . " con el valor " . $valor . " ya esta en uso");

        return true;
    }

    public function editPsswd(string $password){
        echo 'editPsswd';
    }

    public function editUser(string $password){
        echo 'editUser';
    }

    public function registrar(array $data)
    {
     
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
      
        foreach($data as $pos => $valor)
        {
            if(!property_exists($this->class, $pos))
                unset($data[$pos]);
        }
               
        $data['password'] = $password;
        $data['created_at'] = date('Y-m-d H:i:s');
        
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
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

      /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

      /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

     /**
     * @return mixed
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * @param mixed $biography
     */
    public function setBiography($biography)
    {
        $this->biography = $biography;
    }

      /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $username
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }


}
