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
            'errores' => '',
            'data' => [
                'id' => $user->getId(),
                'user' => $user->getUser(),
                'name' => $user->getName(),
                'surname' => $user->getSurname(),
                'email' => $user->getEmail(),
            ]
        ]);
        die();
    }

    public function logout()
    {
        (new AuthToken())->logout();
        echo json_encode([
            'success' => true,
            'errores' =>''
        ]);
        die();
    }

    public function check(){

        $check = new AuthToken();

        if(is_null($check->getUsuario())){

            echo 'null';

        }else{

            print_r($check->getUsuario());

        }
        die();

    }
}
