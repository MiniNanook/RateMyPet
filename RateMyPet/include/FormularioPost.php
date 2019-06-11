<?php

require_once __DIR__.'/Form.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/Pet.php';

class FormularioPost extends Form {

    protected function generaCamposFormulario($datosIniciales) { // Devuelve el HTML necesario para presentar los campos del formulario.
        return '<div class="edit">
                        <div class="edit-title">
                            <h1>Add a Post</h1>
                        </div>
                        <div class="edit-photo">
                            <img name="image" id="output" src="upload/users/default.png">
                            <h3>Image Preview</h3>
                        </div>
                        <div clas="info">
                        <table>
                            <tr>
                                <td>Title: </td>
                                <td><input class="form-control" id = "title" type="text" name="title" placeholder="New Post" required>
                                </td>
                            </tr>
                            <tr>
                                <td>Tags: </td>
                                <td><input class="form-control" id = "tags" type="text" name="tags" placeholder="#Dog" required>
                                </td>
                            </tr>
                            <tr>
                                <td>Description: </td>
                                <td>
                                    <textarea class="form-control" rows="5" cols="40" id = "description" name="description" required>
                                    </textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>Image: </td>
                                <td>
                                    <input type="file" onchange="readURL(this);" name="image" enctype="multipart/form-data" required/>
                                </td>
                                </td>
                            </tr>
                        </table>
                        </div>
                        <input type="hidden" name="idPet" value="'.$_POST["idPet"].'">
                        <button class="button-create">Create!</button>
                </div>';
    }

    protected function procesaFormulario($datos) { // Procesa los datos del formulario nuevo PetPost

        $title = isset($_POST['title']) ? $_POST['title'] : null;
        $tags = isset($_POST['tags']) ? $_POST['tags'] : null;
        $description = isset($_POST['description']) ? $_POST['description'] : null;
        $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : null;
        $idPet = isset($_POST['idPet']) ? $_POST['idPet'] : null;

       /* if (empty($title) or empty($tags) or empty($descrition) or empty($image) or empty($idPet))	{
            header('Location: petprofile.php?idPet='.$idPet.'');
            exit();
        }

        

        if (empty($title))	{
            header('Location: petProfile.php?idPet='.$idPet.'');
            exit();
        }*/

        // We also need to check whether or not the image exists (you can't post anything without an Image)
        $pet = Pet::buscarPet($idPet);
        $post = $pet->addPost($title, $tags, $description, $image); // Create the Post
        if ($image != null) {

            $name_file = $_FILES['image']['name']; // Nombre del archivo
            $tmp_name = $_FILES['image']['tmp_name'];  // Nombre y directorio temporal del archivo subido
            $extension = explode(".", $name_file)[1]; // Extensión del archivo
            
            // Procesa la imagen
            if (!$post->processImage($tmp_name, $extension)) {
                echo 'No se ha podido subir la imagen al servidor.';
                exit();
            }
        }

        header('Location: postMascota.php?id='.$post->idpost().'');
        exit();
    }

}
