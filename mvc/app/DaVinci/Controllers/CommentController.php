<?php

namespace DaVinci\Controllers;


use DaVinci\Auth\AuthToken;
use DaVinci\Core\Route;
use DaVinci\Core\View;
use DaVinci\Validation\Validator;
use DaVinci\Models\Post;
use DaVinci\Models\Comment;

class CommentController
{
    public function create(){
        
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
            'post_id' => ['required', 'numeric'],
            'content' => ['required', 'max:255'],
        ]);

        if(!$validation->passes()) {
            echo json_encode([
                'success' => false,
                'errores' => $validation->getErrores()
            ]);
            die();
        }

        $post = new Post;
        
        try {
            $post->byId($postData['post_id']);
           
            $comment = new Comment;
        
            try {

                $comment->create($postData['content'], $postData['post_id'], $auth->getUsuario()->getId());
                echo json_encode([
                    'success' => true,
                    'errores' => 'Comentario creado con éxito'
                ]);
                die();

            } catch(Exception $e) {

                echo json_encode([
                    'success' => false,
                    'errores' => $e->getMessage()
                ]);
                die();

            }

        } catch(Exception $e) {
            echo json_encode([
                'success' => false,
                'errores' => $e->getMessage()
            ]);
            die();
        }
    }

    public function delete(){
        $id = Route::getUrlParameters()['id'];
        
        $auth = new AuthToken();

        if(is_null($auth->getUsuario())){
            echo json_encode([
                'success' => false,
                'errores' => 'Necesitas estar logeado.'
            ]);
            die();
        }

        $deleteComment = new Comment;

        try {
            $deleteComment->delete($id, $auth->getUsuario()->getId());
            echo json_encode([
                'success' => true,
                'errores' => 'Comentario eliminado con éxito'
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

    public function edit(){}

    public function byPost(){
        $id = Route::getUrlParameters()['id'];

        $getCommentsByPost = new Comment;

        try {
            echo json_encode([
                'success' => true,
                'data' => $getCommentsByPost->byPost($id)
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
