<?php require "views/components/header.php"; ?>

<div class="auth-wrap">
	<div class="auth-card">
		<h1>Register</h1>

		<?php foreach ($errors as $error) { ?>
			<p><?= e($error) ?></p>
		<?php } ?>

		<form method="POST" action="">
			<label>Username:</label>
			<input name="username" type="text" value="<?= e($values['username'] ?? '') ?>">
			<br>

			<label>Email:</label>
			<input name="email" type="email" value="<?= e($values['email'] ?? '') ?>">
			<br>

			<label>Password:</label>
			<input name="password" type="password">
			<br>

			<label>Confirm password:</label>
			<input name="confirm_password" type="password">
			<br>

			<button type="submit">Create account</button>
		</form>

		<p class="typing-note" style="margin-top: 12px;">
			Already have an account? <a href="/login">Login</a>
		</p>
	</div>
</div>

<?php require "views/components/footer.php"; ?>
