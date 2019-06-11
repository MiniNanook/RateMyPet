<?php
    require_once __DIR__ . '/Aplicacion.php';
    require_once __DIR__ . '/config.php';
    require_once __DIR__ . '/Pet.php';   

    $animal_A = isset($_POST['animal_A']) ? $_POST['animal_A'] : null;
    $animal_B_value = isset($_POST['animal_B']) ? $_POST['animal_B'] : null;
    $animal_B_name = isset($_POST['petType']) ? $_POST['petType'] : null;

    // The algorithm simply gets the value of the slider. If the first one is under 60%, that means the user is not confortable voting positive.
    // This functionality could be improved, but due to the lack of time, we decided to keep it simple.
    
    if ($_SESSION['user']->isMod() || $_SESSION['user']->rol() == "admin") { // The moderator is voting
        if (isset($_POST['yes'])) { // The moderator says yes
            Pet::sayYesMod($_POST['petId']);
            header('Location: ../petProfile.php?idPet='.$_POST['petId'].''); // Go to the pet's profile page
            exit();
        } else if (isset($_POST['no'])) { // The moderator says no
            Pet::sayNoMod($_POST['petId']);
            header('Location: ../index.php');
            exit();
        }
    } else {
        if ($animal_A <= 60) { // The user has decided that this pet is not what the owner says it is
            Pet::sayNo($_POST['petId']);
        } else {
            Pet::sayYes($_POST['petId']);
        }
    }

    $previous = "javascript:history.go(-1)"; // Use the calling page as a return
    if (isset($_SERVER['HTTP_REFERER'])) {
        $previous = $_SERVER['HTTP_REFERER'];
        header('Location: '.$previous.'');
    } else {
        header('Location: ../error.php');
    }

?>