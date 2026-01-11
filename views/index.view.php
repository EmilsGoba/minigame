<?php
	$navbar = "/public/css/navbar.css";
	$style = "/public/css/home.css";
	require "views/components/header.php";
?>

<?php require "views/components/navbar.php";?>

<div class="home-wrap">
	<div class="home-card">
		<div class="home-header">
			<div>
				<h1 style="margin: 0;">Choose a game</h1>
				<p class="home-subtitle">Select which minigame you want to play.</p>
			</div>
		</div>

		<div class="home-grid">
			<a class="home-tile" href="/typing">
				<h2 class="home-tile-title">Typing Game</h2>
				<p class="home-tile-desc">Test your speed and accuracy across difficulties.</p>
			</a>
			<a class="home-tile" href="/memory">
				<h2 class="home-tile-title">Memory Game</h2>
				<p class="home-tile-desc">Match cards as fast as you can.</p>
			</a>
		</div>
	</div>
</div>

<?php require "views/components/footer.php";?>