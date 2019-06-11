<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="header">
	<div>
	<a href="index.php"><img src="img/logo-header.png" alt="logo" class="logo"></a>
	</div>
	<nav>
		<ul>
			<li><a href="index.php">Home</a></li>
			<?php
				echo '<li><a href="ownerProfile.php?id='.$_SESSION["user"]->id().'">Profile';
				if ($_SESSION['user']->rol() == 'admin') {
					echo ' 🌟 (ADMIN) </a></li>';
				} else if ($_SESSION['user']->isMod()) {
					echo ' 💠 (MOD) </a></li>';
				} else {
					echo '</a></li>';
				}
				echo '<li><a href="ranking.php">Ranking</a></li>';
			?>
			<li>
				<div class="bar1"> 
					<form method="GET" action="searchResult.php">
						<input type="search" id="search" name="search" placeholder="Search...">
						<button type="submit"></button>
					</form>
				</div>
			<li>
		</ul>
	</nav>
	<nav id="log">
		<ul>
			<li><?php
			if (isset($_SESSION['user'])) {
				echo '<a href="logoutConfirm.php">Logout</a>';
			} else {
				echo '<a href="signup.php">Login/Register</a>';
			}
			?></a></li>
		</ul>
	</nav>
</div>
