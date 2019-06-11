<?php
require_once __DIR__ . '/include/Aplicacion.php';
require_once __DIR__ . '/include/config.php';
require_once __DIR__ . '/include/selectPet.php';
require_once __DIR__ . '/include/getVerification.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Rate My Pet: Post</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/content.css">
    <link rel="stylesheet" href="css/ranking.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/slider.css">
</head>
<?php
require("include/comun/header.php");
?>
<div class="content">
    <h1>Pet Verification</h1>
    <p>Here you will be able to decide whether or not the following pet is legible for being a part of the community.</p>
    <p>If <?php echo '' . $pet->petName(); ?> gets accepted, he will be able to post some cute pictures!</p>
    <p>Note: a rating of less than 60% will mean that this pet is not the type of animal the owner says it is. Please choose the pet you truly think <?php echo '' . $pet->petName(); ?> represents.</p>
    <?php
    if ($_SESSION['user']->isMod() || $_SESSION['user']->rol() == "admin") { // You're a Moderator
        echo '<h2>Psst! You\'re a 💠 (MOD), so you need to wait until the rest of the users vote!</h2>';
    }
    ?>
    <hr>
    <h1>Current Results: </h1>
    <?php
    if ($results != false) {
        echo '<h1>In favour: ' . $results[0] . ' | Not in favour: ' . $results[1] . '</h1>';
        if ($results[0] == 3 || $results[1] == 3) { // Anyone - Can Vote
            echo '<h1>The votes are in! Awaiting the Moderator\'s approval.</h1>';
        }
    } else {
        echo '<h1>In favour: 0 | Not in favour: 0</h1>';
    }
    ?>
    <hr>
    <?php
    echo '<h1>Is ' . $pet->petName() . ' a ' . $pet->petType() . '?</h1>';
    echo '<img class="test-pic" src="' . $pet->getImageSrc() . '">';

    if ($you) { // If you have verified Him
        echo '<h1>You have already voted</h1>';
    } else if ($pet->owner_id() == $_SESSION['user']->id()) { // It's yours
        echo '<h1>You can\'t vote for your own pet!</h1>';
    } else if ($results[0] != 3 && $results[1] != 3 && ($_SESSION['user']->isMod() || $_SESSION['user']->rol() == "admin")) { // Mod - Can't vote
        echo '<h1>Wait until the votes are full (3 in favour, or 3 not in favour) to vote as a Mod.</h1>';
    } else if ($_SESSION['user']->isMod() || $_SESSION['user']->rol() == "admin") { // Mod - Can vote
        // Yes
        echo '<div class="in-line-2">';
        echo '<form action="include/votePet.php" method="POST">';
        echo '<input type="hidden" name="petId" value="' . $pet->petId() . '">';
        echo '<input type="hidden" name="yes" value="yes">';
        echo '<input type="submit" class="button-create" id="inline-buttons" value="Yes">';
        echo '</form>';
        // No
        echo '<form action="include/votePet.php" method="POST">';
        echo '<input type="hidden" name="petId" value="' . $pet->petId() . '">';
        echo '<input type="hidden" name="no" value="no">';
        echo '<input type="submit" class="button-create" id="inline-buttons" value="No">';
        echo '</form>';
        echo '</div>';
    } else if ($results[0] != 3 && $results[1] != 3) { // Anyone - Can Vote
        echo '<form action="include/votePet.php" method="POST">';
        echo '<div class="slidecontainer">
                <h2>How much of a ' . $pet->petType() . ' is ' . $pet->petName() . '?</h2>
                <input name="animal_A" onChange="otherType(\'' . $pet->petName() . '\')" type="range" min="1" max="100" value="100" class="slider" id="myRange"><h1 oninput="percentageA()" id="a">100%</h1>
            </div>';
        echo '<div id="other"></div>';
        echo '<input type="hidden" name="petId" value="' . $pet->petId() . '">';
        echo '<input type="submit" class="button-create" value="Vote">';
        echo '</form>';
    }

    ?>
</div>
<?php
require("include/comun/footer.php");
?>

<script src="js/imagePreview.js"></script>
<script src="js/testOther.js"></script>
</body>

</html>