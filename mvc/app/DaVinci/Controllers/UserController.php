<?php

namespace DaVinci\Controllers;

use DaVinci\Core\App;
use DaVinci\Core\View;
use DaVinci\Models\User;

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
            'user' => ['required', 'min:6'],
            'name' => ['required', 'min:2'],
            'surname' => ['required', 'min:2'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
        ]);

        if(!$validation->passes()) {
            echo json_encode([
                'success' => false,
                'errores' => $validation->getErrores()
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
}