<!DOCTYPE html>
<html>
<head>
	<title>Home - Mini-tweet</title>
	<script type="text/javascript" src="public/js/script.js"></script>
	<link rel="stylesheet" type="text/css" href="public/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="public/css/style.css">
</head>
<body>
<header class="freespace"></header>
<div class="container">
<div class="panel panel-default col-md-3">
	<div class="panel-body">
		<a href="?logout=1">Log out ?</a>
		<h4>Your profile</h4>
		<?php
		$profile = $user->read();
		?>
		<p>Username : <?php echo $profile['username']; ?></p>
		<h4>Send tweet</h4>
		<form action="#" method="post" class="form-inline">
			<input type="hidden" name="to" value="send-tweet">
			<textarea class="form-control" name="tweet" id="tweet" rows="3" placeholder="Today I ate a big burger, not fat enough" onkeypress="remaining();"></textarea>
			<p>remaining letters : <span id="remaining">120</span></p>
			<button type="submit" class="btn btn-default">Submit</button>
		</form>
	</div>
</div>
<div class="panel panel-default col-md-9">
	<div class="panel-body">
	<?php
	$all = $tweets->get();
	if (count($all) <= 0) {
		?>
		<p>You have 0 tweets :( ! Post now !</p>
		<?php
	} else {
		foreach ($all as $value) {
			?>
			<div class="panel panel-default">
				<div class="panel-body">
				<?php echo $value['content']; ?>
				</div>
				<div class="panel-footer"><p>
				Created at : <?php echo $value['created_at']; ?>
				<?php if (!is_null($value['updated_at'])) {
					?>
					Updated at : <?php echo $value['updated_at']; ?>
					<?php
				}
				?></p></div>
			</div>
			<?php
		}
	}
	?>
	</div>
</div>
</div>
</body>
</html>