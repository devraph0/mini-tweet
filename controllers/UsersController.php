<?php
namespace controllers;

use models\Bdd;
use models\Model;
class UsersController extends Model
{
	private $_token;
	private $_username;
	private $_id;

	public function __construct ()
	{
		if (isset($_GET['logout'])) {
			$this->disconnect();
		}
		if (isset($_POST['to'])) {
			switch ($_POST['to']) {
				case 'register':
					$this->create();
					break;
				case 'connection':
					$this->connection();
					break;

				case 'update-user':
					$this->update();
					break;
			}
		}
	}

	private function authError ()
	{
		$this->send('error', ['message' => 'incorrect username or password']);
		return false;
	}

	private function authSuccess ()
	{
		$this->send('success', ['token' => $this->_token, 'username' => $this->_username]);
		$_SESSION['token'] = $this->_token;
		$_SESSION['username'] = $this->_username;
		$_SESSION['id'] = $this->_id;
		return true;
	}

	private function checkUsername ($update = false)
	{
		$db = new Bdd();

		$username = addslashes($_POST['username']);

		if (!$update) {
			$get = $db->getBdd()->prepare('SELECT id FROM users WHERE username = ? AND active = 1');
			$get->bindParam(1, $username);
			$get->execute();
			$id = $get->fetch()['id'];
			if ($id) {
				return false;
			}
			return true;
		} else {
			$get = $db->getBdd()->prepare('SELECT id FROM users WHERE username = ? AND token != ? AND active = 1');
			$get->bindParam(1, $username);
			$get->bindParam(2, $_SESSION['token']);
			$get->execute();
			$id = $get->fetch()['id'];
			if ($id) {
				return false;
			}
			return true;
		}
	}

	public function connection ()
	{
		$username = addslashes($_POST['username']);
		$password = addslashes($_POST['password']);

		$db = new Bdd();
		$get = $db->getBdd()->prepare('SELECT id, password FROM users WHERE username = ? AND active = 1');
		$get->bindParam(1, $username);
		$get->execute();
		$user = $get->fetch(\PDO::FETCH_ASSOC);

		if (!$user) {
			return $this->authError();
		}

		if (!password_verify($password, $user['password'])) {
			return $this->authError();
		}

		$token = sha1(time() * rand(1, 1000));

		$update = $db->getBdd()->prepare('UPDATE users SET token = ? WHERE id = ? AND active = 1');
		$update->bindParam(1, $token);
		$update->bindParam(2, $user['id']);
		if ($update->execute()) {
			$this->_token = $token;
			$this->_username = $username;
			$this->_id = $user['id'];
			return $this->authSuccess();
		}

		return false;
	}

	public function disconnect ()
	{
		session_destroy();
		header('Location:./');
	}

	public function create ()
	{
		$db = new Bdd();

		$username = addslashes($_POST['username']);
		$password = addslashes($_POST['password']);

		$password = password_hash($password, PASSWORD_DEFAULT);

		if ($this->checkUsername()) {
			$create = $db->getBdd()->prepare('INSERT INTO users (username, password, created_at) VALUES (?, ?, NOW())');
			$create->bindParam(1, $username);
			$create->bindParam(2, $password);
			if ($create->execute()) {
				return $this->connection();
			}
		} else {
			$this->send('error', ['message' => 'username already in use']);
			return false;
		}
	}

	public function read ()
	{
		$db = new Bdd();

		$get = $db->getBdd()->prepare('SELECT username, img FROM users WHERE id = ? AND token = ? AND active = 1');
		$get->bindParam(1, $_SESSION['id']);
		$get->bindParam(2, $_SESSION['token']);
		$get->execute();

		$user = $get->fetch(\PDO::FETCH_ASSOC);
		if ($user) {
			//$this->send('success', $user);
			return $user;
		}
		$this->send('error', ['message' => 'an error occured [1]']);
		return false;
	}

	public function update ()
	{
		$db = new Bdd();

		// check username
		if ($this->checkUsername(true)) {
			if (!empty($_POST['photo'])) {
				if (filter_var($_POST['photo'], FILTER_VALIDATE_URL) === FALSE) {
					$this->send('error', 'not an url');
					return false;
				}
				$validExt = array("gif", "jpg", "jpeg", "png");

				$urlExt = pathinfo($_POST['photo'], PATHINFO_EXTENSION);

				if (!in_array($urlExt, $validExt)) {
					$this->send('error', 'not an image (accepted format is : git, jpg, jpeg, png)');
					return false;
				}
			}
			$db = new Bdd();

			$update = $db->getBdd()->prepare('UPDATE users SET username = ?, img = ?, updated_at = NOW() WHERE id = ? AND token = ? AND active = 1');
			$update->bindParam(1, $_POST['username']);
			$update->bindParam(2, $_POST['photo']);
			$update->bindParam(3, $_SESSION['id']);
			$update->bindParam(4, $_SESSION['token']);
			if ($update->execute()) {
				$this->send('success', null);
				return true;
			} else {
				$this->send('error', 'error occured [5]');
				return false;
			}
		} else {
			$this->send('error', 'username already in use');
			return false;			
		}


	}

	public function delete ()
	{
		$db = new Bdd();

		$delete = $db->getBdd()->prepare('UPDATE users SET active = 0 WHERE id = ? AND token = ?');
		$delete->bindParam(1, $_SESSION['id']);
		$delete->bindParam(2, $_SESSION['token']);
		if ($delete->execute()) {
			$this->send('success', null);
			return true;
		}
		$this->send('error', 'error occured [3]');
		return false;
	}
}