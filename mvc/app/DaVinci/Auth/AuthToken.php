<?php
namespace DaVinci\Auth;

use DaVinci\Models\User;
use DaVinci\Session\Session;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\SignedWith;

use DateTimeImmutable;

require_once '../../vendor/autoload.php';

/**
 * Class Auth
 *
 * Administra lo relacionado a la autenticación:
 * - Autenticar.
 * - Cerrar Sesión.
 * - Verificar si está autenticado.
 * - Obtener el usuario autenticado.
 */
class AuthToken
{
    /** @var int|null El id del usuario autenticado. null si no hay ninguno. */
    protected $id;
    /** @var bool Si el usuario está autenticado o no. */
    protected $logged;

    // Agregamos las constantes para el token a la clase.
    const JWT_SECRET = '4ufghy934nfua43hgfp9238yhfw379yr';
    const JWT_ISSUER = 'https://davinci.edu.ar';

    /**
     * Intenta autenticar al usuario, e informa del resultado.
     *
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function login($email, $password)
    {
        // Buscamos si el usuario existe.
//        $usuario = new Usuario;
//        $usuario = $usuario->getByEmail($email);
        if($this->estaAutenticado()) {

            echo json_encode([
                'success' => false,
                'errores' => 'Ya estas logeado.'
            ]);
            die();
        }

        $user = (new User)->getByEmail($email);

        // Verificamos si el usuario existe.
        if($user !== null) {

            // Comparamos el password.
            if(password_verify($password, $user->getPassword())) {
//                $_SESSION['id'] = $usuario->getId();
//                Session::set('id', $usuario->getId());
//                $_SESSION['email'] = $usuario->getEmail();
                $token = $this->generateJWT($user->getId());
                setcookie('token', (string) $token->toString(), [
                    'httponly' => true,
                    'samesite' => 'Lax',
                    'expires' => time() + 60*60*24
                ]);
                $this->id = $user->getId();
                $this->logged = true;
                return true;
            }
        }

        return false;
    }

    /**
     * Genera un token de autenticación, que contenga el id provisto.
     *
     * @param int $id
     * @return \Lcobucci\JWT\Token
     */
    public function generateJWT($id): \Lcobucci\JWT\Token
    {

        // Creamos el encriptador que va a firmar el token.

        $config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::base64Encoded(self::JWT_SECRET)
        );

        $builder = $config->builder();

        $token = $builder
            ->issuedBy(self::JWT_ISSUER)
            ->issuedAt(new DateTimeImmutable())
            ->withClaim('id', $id)
            ->getToken($config->signer(), $config->signingKey());
        
        return $token;
    }

    /**
     * Cierra la sesión del usuario.
     */
    public function logout()
    {
//        unset($_SESSION['id']);
//        Session::remove('id');
        setcookie('token', null, [
            'expires' => time() - 60*60*24,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        $this->logged = false;
    }

    /**
     * Retorna si el usuario está autenticado o no.
     *
     * @return bool
     */
    public function estaAutenticado()
    {
//        return isset($_SESSION['id']);
        if($this->logged) {
            return true;
        }
        $token = $_COOKIE['token'] ?? null;
        return is_string($token) && $this->validateJWT($token);
    }


    /**
     * Verifica si el token es válido, en cuyo caso retorna un array con el id del usuario del token.
     *
     * @param string $token
     * @return bool|array
     */
    public function validateJWT($RequestToken)
    {

        // Obtenemos el objeto de Configuration, pasándole la clase para la encriptación que queremos que
        // use, y la key correspondiente.
        $config = Configuration::forSymmetricSigner(
            new Sha256(),
            InMemory::base64Encoded(self::JWT_SECRET)
        );

        // Parseamos el token con el Parser que obtenemos del Config.
        $token = $config->parser()->parse($RequestToken);

        // Validamos que el token sea correcto.
        try {
            // Primero definimos las 'constraints' (validaciones) que queremos.
            // Cada constraint la indicamos instanciando la clase correspondiente.
            $constraints = [
                // Los valores de signer y signing-Key deberían ser los mismos que usamos al momento de crear
                // el token.
                new SignedWith($config->signer(), $config->signingKey()),
                new IssuedBy(self::JWT_ISSUER)
            ];

            // Hacemos la verificación.
            // Noten que las constraints las pasamos usando el "splat" operator de php, que funciona básicamente
            // como el spread operator de JS.
            $config->validator()->assert($token, ...$constraints);

            // Si lo hicimos bien, tenemos la data del token disponible.
            $this->id = $token->claims()->get('id');
            return [
                'id' => $this->id
            ];
        } catch(\Exception $e) {
            return false;
        }

    }

    /**
     * Retorna el usuario autenticado.
     * Si no está autenticado, retorna null.
     *
     * @return null|User
     */
    public function getUsuario()
    {

        if(!$this->estaAutenticado()) {

            return null;
        }

//        $usuario = (new Usuario)->getByPk($_SESSION['id']);
//        return $usuario;
        // Abreviado...
//        return (new Usuario)->getByPk($_SESSION['id']);

        return (new User)->getByPk($this->id);
    }
}
