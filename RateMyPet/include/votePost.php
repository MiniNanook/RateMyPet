<?php
    require_once __DIR__ . '/Aplicacion.php';
    require_once __DIR__ . '/config.php';
    require_once __DIR__ . '/Post.php';   

    // The algorithm simply gets the value of the slider. If the first one is under 60%, that means the user is not confortable voting positive.
    // This functionality could be improved, but due to the lack of time, we decided to keep it simple.
    
    if ($_SESSION['user']->isMod() || $_SESSION['user']->rol() == "admin") { // The moderator is voting
        if (isset($_POST['yes'])) { // The moderator says yes
            Post::sayYesMod($_POST['postId']);
            header('Location: ../postMascota.php?id='.$_POST['postId'].''); // Go to the Post's profile page
            exit();
        } else if (isset($_POST['no'])) { // The moderator says no
            Post::sayNoMod($_POST['postId']);
        }
    } else {
        if (isset($_POST['yes'])) { // Yes
            Post::sayYes($_POST['postId']);
        } else if (isset($_POST['no'])) { // No
            Post::sayNo($_POST['postId']);
        }
    }

    $previous = "javascript:history.go(-1)"; // Use the calling page as a return
    if (isset($_SERVER['HTTP_REFERER'])) {
        $previous = $_SERVER['HTTP_REFERER'];
        header('Location: '.$previous.'');
    } else {
        header('Location: ../adminOptions.php');
    }

?>