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
			<form action="#" method="post">
				<input type="hidden" name="to" value="update-user">
				<input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>">
				<img src="<?php echo (!empty($profile['img'])) ? $profile['img'] : 'public/img/no-avatar.jpg'; ?>" class="img-responsive">
				<input type="text" class="form-control" id="photo" name="photo" value="<?php echo $profile['img']; ?>" placeholder="Avatar url">
				<div class="form-group">
					
				<label for="username">Username : </label>
				<input type="text" class="form-control" id="username" name="username" value="<?php echo $profile['username']; ?>">
				</div>
				<button class="btn btn-default" type="submit">Update</button>
			</form>
			<h4>Send tweet</h4>
			<form action="#" method="post">
				<input type="hidden" name="to" value="send-tweet">
				<textarea class="form-control" name="tweet" id="tweet" rows="3" placeholder="I ate a big burger today, not fat enough" onkeyup="remaining();"></textarea>
				<p>remaining letters : <span id="remaining">120</span></p>
				<button type="submit" class="btn btn-default">Submit</button>
			</form>
		</div>
	</div>
	<div class="panel panel-default col-md-9">
		<div class="panel-body">
		<?php
		$all = $tweets->get();
		$page = $tweets->count();
		if (count($all) <= 0) {
			?>
			<p>You have 0 tweets :( ! Post now !</p>
			<?php
		} else {
			foreach ($all as $value) {
				?>
				<div class="panel panel-default">
					<div class="panel-body">
					<form action="#" method="post">
						<input type="hidden" name="to" value="update-tweet">
						<input type="hidden" name="id" value="<?php echo $value['id']; ?>">
						<textarea class="form-control" name="tweet" id="tweetupdate<?php echo $value['id']; ?>" rows="2" onkeyup="remainingupdate();"><?php echo $value['content']; ?></textarea>
						<p>remaining letters : <span id="remainingupdate<?php echo $value['id']; ?>">120</span></p>
						<button type="submit" class="btn btn-default">Update</button>
					</form>
					</div>
					<div class="panel-footer"><p>
					Created at : <?php echo $value['created_at']; ?>
					<?php if (!is_null($value['updated_at'])) {
						?>
						Updated at : <?php echo $value['updated_at']; ?>
						<?php
					}
					?><a href="?delete=<?php echo $value['id']; ?>" style="float: right;">Remove ?</a></p></div>
				</div>
				<?php
			}
			?>
				<ul class="pagination">
				<?php
				for ($i=1; $i <= $page; $i++) { 
					?>
					<li><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
					<?php
				}
				?>
				</ul>
			<?php
		}
		?>
		</div>
	</div>
</div>
<script type="text/javascript">
	remaining();
</script>
</body>
</html>