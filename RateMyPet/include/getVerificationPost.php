<?php
    require_once __DIR__ . '/Aplicacion.php';
    require_once __DIR__ . '/config.php';
    require_once __DIR__ . '/Post.php'; 
    require_once __DIR__ . '/Usuario.php'; 

    $you = $_SESSION['user']->verifiedPost($_GET['id']); // Check if you've already voted
    $results = array();
    $results = Post::getVerificationArray($_GET['id']); // Returns an array with the number of current verifications

?>