<?php require "views/components/navbar.php"; ?>
<?php
	$navbar = "/public/css/navbar.css";
	$style = "/public/css/leaderboard.css";
	require "views/components/header.php";
?>

<div class="leaderboard-wrap">
	<h1>Leaderboard</h1>

	<div class="leaderboard-card">
		<form method="GET" action="/leaderboard" class="leaderboard-controls">
			<label for="difficulty">Difficulty:</label>
			<select id="difficulty" name="difficulty" onchange="this.form.submit()">
				<?php foreach (($difficulties ?? []) as $diff): ?>
					<option value="<?= e((string)$diff['id']) ?>" <?= ((int)$diff['id'] === (int)($selectedDifficultyId ?? -1)) ? 'selected' : '' ?>>
						<?= e($diff['name']) ?>
					</option>
				<?php endforeach; ?>
			</select>
			<noscript><button type="submit">View</button></noscript>
		</form>

		<?php if (empty($difficulties)): ?>
			<p class="leaderboard-note">No difficulties found.</p>
		<?php elseif (empty($scores)): ?>
			<p class="leaderboard-note">No scores yet for this difficulty.</p>
		<?php else: ?>
			<table class="leaderboard-table">
				<thead>
					<tr>
						<th>#</th>
						<th>User</th>
						<th>WPM</th>
						<th>Accuracy</th>
						<th>Time (s)</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($scores as $i => $row): ?>
						<tr>
							<td><?= (int)$i + 1 ?></td>
							<td><?= e($row['username'] ?? '') ?></td>
							<td><?= e((string)($row['words_per_minute'] ?? '0')) ?></td>
							<td><?= e(isset($row['accuracy']) ? number_format((float)$row['accuracy'], 0) . '%' : '-') ?></td>
							<td><?= e((string)($row['time_seconds'] ?? '0')) ?></td>
							<td><?= e((string)($row['created_at'] ?? '')) ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>
	</div>
</div>

<?php require "views/components/footer.php"; ?>

