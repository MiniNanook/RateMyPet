<?php

    require_once __DIR__.'/config.php';
    require_once __DIR__.'/Usuario.php';

    if (isset($_POST['id']) && $_SESSION['user']->rol() == "admin") { // Delete someone else's account
        $user = Usuario::buscaUsuarioId($_POST['id']);
        $user->deleteAccount();
        header("Location: ../adminOptions.php");
    } else if (isset($_POST['petId']) && $_SESSION['user']->rol() == "admin") {
        $pet = Pet::buscarPet($_POST['petId']);
        $pet->borrarMascota();
        header("Location: ../adminOptions.php");
    } else if ($_SESSION['user']->rol != "admin") {
        $_SESSION['user']->deleteAccount(); // We're sorry to see you go... :(

        //Doble seguridad: unset + destroy
        unset($_SESSION["login"]);
        unset($_SESSION["esAdmin"]);
        unset($_SESSION["nombre"]);
        unset($_SESSION["user"]);
    
        session_destroy();
        header("Location: ../signup.php");
    }

?>