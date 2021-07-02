<?php

namespace DaVinci\Controllers;


use DaVinci\Auth\AuthToken;
use DaVinci\Core\View;
use DaVinci\Validation\Validator;

class AuthController
{
    public function login()
    {
        $jsonData = file_get_contents('php://input');
        $postData = json_decode($jsonData, true);

        $validation = new Validator($postData, [
            'email' => ['required','email'],
            'password' => ['required', 'min:8'],
        ]);

        if(!$validation->passes()) {
            echo json_encode([
                'success' => false,
                'errores' => $validation->getErrores()
            ]);
            die();
        }

        $auth = new AuthToken();
        if(!$auth->login($postData['email'], $postData['password'])) {
            echo json_encode([
                'success' => false,
                'errores' => 'Las credenciales no son validas.'
            ]);
            die();
        }

        $user = $auth->getUsuario();

        echo json_encode([
            'success' => true,
            'user' => $user
        ]);
        die();
    }

    public function logout()
    {
        (new AuthToken())->logout();
        echo json_encode([
            'success' => true,
            'errores' =>'Sesión cerrada con éxito.'
        ]);
        die();
    }

    public function getAuth(){

        $auth = new AuthToken();

        if(is_null($auth->getUsuario())){
            echo json_encode([
                'success' => false,
                'errores' =>'Debes iniciar sesion'
            ]);
            die();
        }else{
            echo json_encode([
                'success' => true,
                'user' => [
                    "id" => $auth->getUsuario()->getId(),
                    "user" => $auth->getUsuario()->getUser(),
                    "name" => $auth->getUsuario()->getName(),
                    "surname" => $auth->getUsuario()->getSurname(),
                    "email" => $auth->getUsuario()->getEmail(),
                    "biography" => $auth->getUsuario()->getBiography(),
                    "create_at" => $auth->getUsuario()->getCreatedAt(),
                ]
            ]);
            die();
        }

    }
}
