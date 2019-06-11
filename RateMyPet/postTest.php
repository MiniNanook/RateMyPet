<?php
require_once __DIR__ . '/include/Aplicacion.php';
require_once __DIR__ . '/include/config.php';
require_once __DIR__ . '/include/Comment.php';
require_once __DIR__ . '/include/selectPost.php';
require_once __DIR__ . '/include/getVerificationPost.php';
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
    <h1>Post Verification</h1>
    <p>Here you will be able to decide whether or not the following post belongs to the corresponding pet.</p>
    <p>If <?php echo '' . $pet->petName(); ?> doesn't seem to appear here, then the post is not legible.<p>
            <p>Simply click on "Yes" or "No" to vote for this post.</p>
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
            echo '<h1>Does ' . $pet->petName() . ' appear in this post?</h1>';
            echo '<h1>Is the post appropiate?</h1>';

            echo '' . $post->toString(false);

            if ($you) { // If you have verified Him
                echo '<h1>You have already voted</h1>';
            } else if ($pet->owner_id() == $_SESSION['user']->id()) { // It's yours
                echo '<h1>You can\'t vote for your own post!</h1>';
            } else if ($results[0] != 3 && $results[1] != 3 && ($_SESSION['user']->isMod() || $_SESSION['user']->rol() == "admin")) { // Mod - Can't vote
                echo '<h1>Wait until the votes are full (3 in favour, or 3 not in favour) to vote as a Mod.</h1>';
            } else {
                echo '<hr>';
                // Yes
                echo '<div class="in-line-2">';
                echo '<form action="include/votePost.php" method="POST">';
                echo '<input type="hidden" name="postId" value="' . $post->idpost() . '">';
                echo '<input type="hidden" name="yes" value="yes">';
                echo '<input type="submit" class="button-create" id="inline-buttons" value="Yes">';
                echo '</form>';
                // No
                echo '<form action="include/votePost.php" method="POST">';
                echo '<input type="hidden" name="postId" value="' . $post->idpost() . '">';
                echo '<input type="hidden" name="no" value="no">';
                echo '<input type="submit" class="button-create" id="inline-buttons" value="No">';
                echo '</form>';
                echo '</div>';
            }

            ?>
</div>
<?php
require("include/comun/footer.php");
?>
</body>

</html>