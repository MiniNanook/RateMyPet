<?php
require_once __DIR__ . '/include/Usuario.php';
require_once __DIR__ . '/include/Post.php';
require_once __DIR__ . '/include/config.php';
require_once __DIR__ . '/include/Comment.php'; //devuelve un objeto de tipo Post
require_once __DIR__ . '/include/selectPost.php'; //devuelve un objeto de tipo Post

//css a tope en esta vista uwu
?>

<!DOCTYPE html>
<html>

<head>
	<title>Post</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/header.css">
	<link rel="stylesheet" href="css/footer.css">
	<link rel="stylesheet" href="css/content.css">
	<link rel="stylesheet" href="css/post.css">
	<link rel="stylesheet" type="text/css" href="css/slick/slick/slick.css" />
	<link rel="stylesheet" type="text/css" href="css/slick/slick/slick-theme.css" />
</head>

<body>
	<?php
	require("include/comun/header.php");
	?>

	<div class="content">
		<?php

		if ($pending && ($me || $mod || $_SESSION['user']->rol() == "admin")) { // I'm the only one that can see this post (and a moderator)
			echo '<h1>This post needs to be verified.</h1>';
			echo '' . $post->toString(false); // Print the Post
		} else if (!$pending) { // Not pending || Not me
			echo '' . $post->toString(true); // Print the Post
			echo '<hr>';
			echo '<div id="post-like">';
			echo '<form action="include/likePost.php" method="POST">'; // Like / dislike the post
			echo '<input type="hidden" name="post" value="' . $post->idpost() . '">';
			if ($like) { // I already like the post
				echo '<input type="hidden" name="type" value="dislike">';
				echo '<button type="submit" class="button-create">Un-Pet (Un-Like)</button>';
			} else { // I like the post
				echo '<input type="hidden" name="type" value="like">';
				echo '<button type="submit" class="button-create">Pet (Like)</button>';
			}
			echo '</form>'; // Like / dislike the post
			echo '</div>';

			echo '<hr>';
			if ($comments->num_rows > 0) {
				echo '<h1>Comments</h1>';
				echo '<div class="multiple-items">';
				while ($row = $comments->fetch_assoc()) {
					echo '<div>';
					$comment = Comment::parseComment($row['idPost'], $row['idUser'], $row['idcomment']);
					echo $comment->toString();
					$likedComment = $_SESSION['user']->checkLikedComment($_GET['id'], $comment->idcomment());
					echo '<form action="include/likeComment.php" method="POST">'; // Like / dislike the post
					echo '<input type="hidden" name="post" value="' . $post->idpost() . '">';
					echo '<input type="hidden" name="idComment" value="' . $comment->idcomment() . '">';
					if ($likedComment) { // I already like the post
						echo '<input type="hidden" name="type" value="dislike">';
						echo '<button type="submit" class="button-create">Unlike comment</button>';
					} else { // I like the post
						echo '<input type="hidden" name="type" value="like">';
						echo '<button type="submit" class="button-create">Like comment</button>';
					}
					echo '</form>';
					echo '</div>';
				}
				echo '</div>';
			} else {
				echo '<h1>No comments to display!</h1>';
				echo '<form method="POST" action="addComment.php">';
				echo '<input type="hidden" name="idPost" value="' . $post->idpost() . '">';
				echo '<button type="submit" class="button-create">Add comment</button>';
				echo '</form>';
			}
		}
		?>
	</div>

	<?php
	require("include/comun/footer.php");
	?>
	<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script src="css/slick/slick/slick.min.js"></script>
	<script src="js/slickSettings.js"></script>
</body>

</html>