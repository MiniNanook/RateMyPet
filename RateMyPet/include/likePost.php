<?php
    require_once __DIR__ . '/Aplicacion.php';
    require_once __DIR__ . '/config.php';
    require_once __DIR__ . '/Usuario.php';

    if (isset($_POST['type']) && isset($_POST['post'])) {
        if ($_POST['type'] == "like") { // Like the post
            $_SESSION['user']->likePost($_POST['post']);
        } else { // Dislike the post
            $_SESSION['user']->unlikePost($_POST['post']);
        }
    } else {
        header('Location: ../error.php');
    }
    
    $previous = "javascript:history.go(-1)"; // Use the calling page as a return
    if (isset($_SERVER['HTTP_REFERER'])) {
        $previous = $_SERVER['HTTP_REFERER'];
        header('Location: '.$previous.'');
    } else {
        header('Location: ../adminOptions.php');
    }

?>