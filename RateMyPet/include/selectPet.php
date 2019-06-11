<?php
require_once __DIR__.'/config.php';
require_once __DIR__.'/Usuario.php';
require_once __DIR__.'/Pet.php';
$petID = $_GET['idPet'];
$pet = Pet::buscarPet($petID); // Search for requested Pet
$mine = false;
if ($pet->owner_id() == $_SESSION['user']->id()) {
    $mine = true;
}
$name = "";
$following = false;
if (!$mine) { // Give me the other owner's name
     $name = Pet::buscarNombreDueño($pet->owner_id());
     // Tell me if I follow him
     if ($_SESSION['user']->followsPet($petID)) {
        $following = true;
     }
}
if (!$pet) { // No pet with that id was found
    header('Location: error.php');
}
$verified = $pet->isVerified();
?>