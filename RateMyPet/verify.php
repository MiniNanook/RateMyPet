<?php
require_once __DIR__ . '/include/config.php';
require_once __DIR__ . '/include/loadVerify.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Ranking</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/content.css">
    <link rel="stylesheet" href="css/ranking.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" type="text/css" href="css/slick/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="css/slick/slick/slick-theme.css" />
</head>

<body>
    <?php
    require('include/comun/header.php');
    ?>
    <div class="content">
        <h1>These Pets need to get verified: </h1>
        <div class="multiple-items">
            <?php
            $counter = 0;
            while ($row = $pets->fetch_assoc()) {
                echo '<div class="rank">';
                $counter++;
                $pet = Pet::buscarPet($row['idPet']);
                echo '<h1>#' . $counter . ' <a href="petTest.php?idPet=' . $pet->petId() . '">' . $pet->petName() . '</h1>';
                echo '<img class="pet-pic" src="' . $pet->getImageSrc() . '"></a>';
                echo '</div>';
            }
            ?>
        </div>
        <h1>These Posts need to get verified: </h1>
        <div class="multiple-items">
            <?php
            $counter = 0;
            while ($row = $posts->fetch_assoc()) {
                $post = Post::buscaPost($row['idpost']);
                $pet = Pet::buscarPet($row['petid']);
                echo '<div class="fourinline container card">';
                echo '<h2>Post from: ' . $pet->petName() . '</h2>';
                echo '<h3>at ' . $post->time() . '</h3>';
                if (file_exists('upload/posts/' . $post->idPost() . '.png')) {
                    $path = 'upload/posts/' . $post->idPost() . '.png';
                } else if (file_exists('upload/posts/' . $post->idPost() . '.jpg')) {
                    $path = 'upload/posts/' . $post->idPost() . '.jpg';
                } else if (file_exists('upload/posts/' . $post->idPost() . '.jpeg')) {
                    $path = 'upload/posts/' . $post->idPost() . '.jpeg';
                }
                echo '<a href="postTest.php?id=' . $post->idPost() . '"><img src="' . $path . '" style="width:100%" class="hover-opacity"></a>
                                    <div class="container white">
                                        <p>' . $post->title() . '</p>
                                        <p>' . $post->description() . '</p>
                                    </div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
    <?php
    require('include/comun/footer.php');
    ?>
    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="css/slick/slick/slick.min.js"></script>
    <script src="js/slickSettingsRanking.js"></script>
    <script src="js/slickSettingsTop.js"></script>
    <script src="js/timerRanking.js"></script>
</body>

</html>