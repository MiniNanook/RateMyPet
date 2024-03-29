<?php
require_once __DIR__ . '/include/Usuario.php';
require_once __DIR__ . '/include/config.php';
require_once __DIR__ . '/include/selectUser.php';	// This loads the current viewed user ($user) and checks if it's me ($me)	
?>

<!DOCTYPE html>
<html>

<head>
	<title>Rate My Pet - profile</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/header.css">
	<link rel="stylesheet" href="css/footer.css">
	<link rel="stylesheet" href="css/content.css">
	<link rel="stylesheet" href="css/profile.css">
	<link rel="stylesheet" type="text/css" href="css/slick/slick/slick.css" />
	<link rel="stylesheet" type="text/css" href="css/slick/slick/slick-theme.css" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<?php
	require("include/comun/header.php");
	?>

	<div class="content">
		<div class="data">
			<div class="profile-image">
				<?php
				if (!$me) { // I can't give mod to myself
					if ($_SESSION['isAdmin']) {
						if ($user->isMod()) {
							echo '<h1>' . $user->username() . ' is a Mod!</h1>';
							echo '<form action="include/moderator.php?act=Revoke&id=' . $user->id() . '" method="POST">
									<button class="button-create"> Revoke Mod Priviledges </button>
								</form>';
						} else {
							echo '<form action="include/moderator.php?act=Give&id=' . $user->id() . '" method="POST">
									<button class="button-create"> Give Mod Priviledges </button>
									</form>';
						}
					}
				}
				echo '<img src="' . $user->getImageSrc() . '">';
				?>
			</div>
			<div class="info">
				<?php
				echo '<h2>' . $user->username() . ' (aka: ' . $user->fullName() . ')';
				if ($user->isMod()) {
					echo ' 💠 (MOD)';
				}
				if ($user->rol() == 'admin') {
					echo ' 🌟 (ADMIN)';
				}
				echo '</h2>';
				echo '<h2>Followers: <a href="followers.php?followersUsers&id=' . $user->id() . '">' . $user->followerAmount() . '</a> | ';
				echo 'Following: <a href="followers.php?followingUsers&id=' . $user->id() . '">' . $user->followingAmount() . '</a></h2>';
				// Likes / Repets

				echo '<h2>Likes: <a href="myLikes.php?id=' . $user->id() . '">' . $user->likedAmount() . '</a></h2>';


				// Edit Button
				if ($me) {
					echo '<button type="button" class="button-create" onclick="window.location.href=\'updateUser.php?id=' . $user->id() . '\'">Edit Profile</button>';
				} else {
					if ($following) {
						echo '<form action="include/follow.php" method="POST">
								<input type="hidden" name="action" value="unfollowUser">
								<input type="hidden" name="id2" value="' . $user->id() . '">
								<input type="submit" class="button-create" value="UnFollow">
							</form>';
					} else {
						echo '<form action="include/follow.php" method="POST">
								<input type="hidden" name="action" value="followUser">
								<input type="hidden" name="id2" value="' . $user->id() . '">
								<input type="submit" class="button-create" value="Follow">
							</form>';
					}
					if ($_SESSION['user']->rol() == "admin") {
						echo '<hr>';
						echo '<h1>You\'re the Admin!</h1>';
						echo '<form method="POST" action="include/deleteAccount.php">
                        			<input type="hidden" name="id" value="' . $user->id() . '">
                        			<input type="submit" class="button-create" value="Delete Account">
                    			</form>';
					}
				}
				?>
			</div>
		</div>
		<hr>
		<div class="pets">
			<?php // My pets
			if ($me) {
				echo '<h1>My pets</h1>';
			} else {
				echo '<h1>' . $user->username() . '\'s Pets</h1>';
			}
			?>
			<div class="multiple-items">
				<?php
				if ($myPets->num_rows > 0) { // Iterate through all of my pets
					while ($row = $myPets->fetch_assoc()) {
						$pet = Pet::buscarPet($row['idPet']);
						echo '<a href="petProfile.php?idPet=' . $pet->petId() . '">';
						echo '<div class="pet-view">
								<h1>' . $pet->petName() . '</h1>
								<h2><img class="pet-pic" src="' . $pet->getImageSrc() . '"></h2>
								</div>';
						echo '</a>';
					}
				} else {
					echo '<div>';
					if ($me) {
						echo "<h2>You don't own any pets!</h2>";
					} else {
						echo '<h1>' . $user->username() . ' doesn\'t own any pets!</h1>';
					}
					echo '</div>';
				}
				?>
			</div>
			<div class="add-pet">
				<?php
				if ($me) {
					echo '<form action="addPet.php" method="POST">
							<input class="button-create" id="addpet" type="submit" value="Add a Pet">
						</form>';
				}
				?>
			</div>
		</div>
	</div>
	<?php
	require("include/comun/footer.php");
	?>
	<script src="js/changeImage.js"> </script>
	<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<script src="css/slick/slick/slick.min.js"></script>
	<script src="js/slickSettingsOwner.js"></script>
</body>

</html>