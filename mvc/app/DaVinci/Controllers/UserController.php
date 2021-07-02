<?php

namespace DaVinci\Controllers;

use DaVinci\Core\App;
use DaVinci\Core\View;
use DaVinci\Models\User;

use DaVinci\Auth\AuthToken;

use Davinci\Validation\Validator;

class UserController
{
    public function register()
    {
        /*$params = Route::getUrlParameters();
        $id = $params['id'];*/
        
        $data = file_get_contents('php://input');
        $postData = json_decode($data, true);

        $validation = new Validator($postData,[
            'user' => ['required', 'min:6', "unique:user"],
            'name' => ['required', 'min:2'],
            'surname' => ['required', 'min:2'],
            'email' => ['required', 'email', 'unique:email'],
            'password' => ['required', 'min:8'],
            'confirm_password' => ['required', 'min:8']
        ]);

        if(!$validation->passes()) {
            echo json_encode([
                'success' => false,
                'errores' => $validation->getErrores()
            ]);
            die();
        }

        iF($postData['password'] !== $postData['confirm_password']){
            echo json_encode([
                'success' => false,
                'errores' => 'Las contraseñas deben ser iguales'
            ]);
            die();
        }

        $user = new User;
        
        try {
            $user->registrar($postData);
            echo json_encode([
                'success' => true,
                'errores' => ''
            ]);
            die();
        } catch(Exception $e) {
            echo json_encode([
                'success' => false,
                'errores' => $e->getMessage()
            ]);
            die();
        }
    }

    public function editUser()
    {
        $data = file_get_contents('php://input');
        $postData = json_decode($data, true);

        $auth = new AuthToken();

        if(is_null($auth->getUsuario())){
            echo json_encode([
                'success' => false,
                'errores' => 'Necesitas estar logeado.'
            ]);
            die();
        }

        $validation = new Validator($postData,[
            'user' => ['required', 'min:6'],
        ]);

        if(!$validation->passes()) {
            echo json_encode([
                'success' => false,
                'errores' => $validation->getErrores()
            ]);
            die();
        }

        if($postData['user'] == $auth->getUsuario()->getUser()){
            echo json_encode([
                'success' => false,
                'errores' => 'El nombre de usuario que se quiere modificar es el mismo que el anterior.'
            ]);
            die();
        }

        $user = new User;

        try {
            $user->editUser($postData['user']);
            echo json_encode([
                'success' => true,
                'errores' => 'Nombre de usuario editado con éxito'
            ]);
            die();
        } catch(Exception $e) {
            echo json_encode([
                'success' => false,
                'errores' => $e->getMessage()
            ]);
            die();
        }
        
    }

    public function editPassword()
    {
        $data = file_get_contents('php://input');
        $postData = json_decode($data, true);

        $auth = new AuthToken();

        if(is_null($auth->getUsuario())){
            echo json_encode([
                'success' => false,
                'errores' => 'Necesitas estar logeado.'
            ]);
            die();
        }

        $validation = new Validator($postData,[
            'password' => ['required', 'min:8'],
            'confirm_password' => ['required', 'min:8']
        ]);

        if(!$validation->passes()) {
            echo json_encode([
                'success' => false,
                'errores' => $validation->getErrores()
            ]);
            die();
        }

        if($postData['password'] !== $postData['confirm_password']){
            echo json_encode([
                'success' => false,
                'errores' => 'Las contraseñas deben ser iguales.'
            ]);
            die();
        }

        $password = password_hash($postData['password'], PASSWORD_DEFAULT);

        $user = new User;

        try {
            $user->editPsswd($password);
            echo json_encode([
                'success' => true,
                'errores' => 'Contraseña editada con éxito'
            ]);
            die();
        } catch(Exception $e) {
            echo json_encode([
                'success' => false,
                'errores' => $e->getMessage()
            ]);
            die();
        }
        
    }

    public function editBiography()
    {
        $data = file_get_contents('php://input');
        $postData = json_decode($data, true);

        $auth = new AuthToken();

        if(is_null($auth->getUsuario())){
            echo json_encode([
                'success' => false,
                'errores' => 'Necesitas estar logeado.'
            ]);
            die();
        }

        $validation = new Validator($postData,[
            'biography' => ['required', 'max:255'],
        ]);

        if(!$validation->passes()) {
            echo json_encode([
                'success' => false,
                'errores' => $validation->getErrores()
            ]);
            die();
        }

        if($postData['biography'] == $auth->getUsuario()->getBiography()){
            echo json_encode([
                'success' => false,
                'errores' => 'La biografia que se quiere modificar es la misma que la anterior.'
            ]);
            die();
        }

        $user = new User;

        try {
            $user->editBiography($postData['biography']);
            echo json_encode([
                'success' => true,
                'errores' => 'Biografia editada con éxito'
            ]);
            die();
        } catch(Exception $e) {
            echo json_encode([
                'success' => false,
                'errores' => $e->getMessage()
            ]);
            die();
        }
        
    }
}