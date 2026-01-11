<?php
	$navbar = "/public/css/navbar.css";
	$style = "/public/css/typing.css";
	require "views/components/header.php";
?>

<?php require "views/components/navbar.php";?>




<div class="typing-wrap">
	<h1>Typing Speed</h1>

	<div class="typing-card">
		<div class="typing-row" style="margin-bottom: 12px;">
			<div class="typing-stat">
				<label for="difficultySelect">Difficulty:</label>
				<select id="difficultySelect">
					<option value="easy">Easy</option>
					<option value="medium">Medium</option>
					<option value="hard">Hard</option>
					<option value="hardcore">Hardcore</option>
				</select>
			</div>
			<div class="typing-stat">Words: <strong><span id="wordCount">0</span></strong></div>
		</div>

		<div class="typing-row" style="margin-bottom: 12px;">
			<div class="typing-stat">Time: <strong><span id="time">0.0</span>s</strong></div>
			<div class="typing-stat">WPM: <strong><span id="wpm">0</span></strong></div>
			<div class="typing-stat">Accuracy: <strong><span id="accuracy">100</span>%</strong></div>
			<div class="typing-stat">Errors: <strong><span id="errors">0</span></strong></div>
		</div>

		<div id="textDisplay" class="typing-text" aria-label="Text to type"></div>

		<div class="typing-controls">
			<button id="restartBtn" type="button">Restart</button>
			<span class="typing-note">Timer starts on your first keystroke. Test ends at 60s or when you finish the text.</span>
		</div>

		<div style="margin-top: 12px;">
			<label for="textInput">Type here:</label>
			<textarea id="textInput" placeholder="Start typing…"></textarea>
		</div>

		<p id="saveStatus" class="typing-note"></p>
	</div>
</div>

<?php $typingJsV = @filemtime(__DIR__ . '/../public/js/typing.js') ?: time(); ?>
<script src="/public/js/typing.js?v=<?= $typingJsV ?>" defer></script>
<?php require "views/components/footer.php"; ?>
