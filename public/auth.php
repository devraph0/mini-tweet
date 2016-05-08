<!DOCTYPE html>
<html>
<head>
	<title>Mini-tweet auth</title>
	<script type="text/javascript" src="public/js/script.js"></script>
	<link rel="stylesheet" type="text/css" href="public/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="public/css/style.css">
</head>
<body>
	<header class="freespace"></header>
	<div class="container">
		<div class="col-md-offset-4 col-md-3 box-auth">
			<ul class="nav nav-tabs">
				<li class="active" id="select-connection"><a href="#" onclick="menu_connection()">Connexion</a></li>
				<li id="select-register"><a href="#" onclick="menu_register()">Inscription</a></li>
			</ul>
			<form action="#" method="post" id="connection">
				<input type="hidden" name="to" value="connection">
				<h3>Connexion</h3>
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" class="form-control" id="username" name="username" placeholder="Username">
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Password">
				</div>
				<button type="submit" class="btn btn-default">Submit</button>
			</form>
			<form action="#" method="post" id="register" style="display:none;">
				<input type="hidden" name="to" value="register">
				<h3>Inscription</h3>
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" class="form-control" id="username" name="username" placeholder="Username">
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Password">
				</div>
				<button type="submit" class="btn btn-default">Submit</button>
			</form>
		</div>
	</div>
</body>
</html>