<?php

require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Post.php';

class FormularioComment extends Form {

    protected function generaCamposFormulario($datosinicio) {
        $postId = $_POST['idPost'];
        return '<div class="edit">
                        <div class="edit-title">
                            <h1>Add a Comment</h1>
                        </div>
                        <div clas="info">
                            <table>
                                <td>What\'s on you mind?</td>
                                <td>
                                    <input class="form-control" type="text" name="content" placeholder="Nice dog!"/>
                                    <input type="hidden" name="idPost" value="'.$postId.'"/>
                                </td>
                            </table>
                        </div>
                    <button class="button-create">Add Comment</button>
                </div>';
    }

    protected function procesaFormulario($datosproceso) {
        $erroresFormulario = array();
    
        $content = isset($_POST['content']) ? $_POST['content'] : null;
        $idPost = $datosproceso['idPost'];
        $idUser = $_SESSION['user']->id();

        if (empty($content)) {
            $erroresFormulario[] = "Say something, don't be shy!";
        }        
        if (count($erroresFormulario) === 0) {
            Post::addComment($idUser, $idPost, $content);
        }
        header('Location: postMascota.php?id='.$idPost.'');
        exit();
    }
        
}

?>
