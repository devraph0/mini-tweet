<?php
namespace controllers;

use models\Bdd;
use models\Model;
class UsersController extends Model
{
	private $_token;
	private $_username;
	private $_id;

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
			$this->send('success', $user);
			return true;
		}
		$this->send('error', ['message' => 'an error occured [1]']);
		return false;
	}

	public function update ()
	{
		$db = new Bdd();

		// change username
		if (isset($_POST['username'])) {
			if ($this->checkUsername(true)) {
				if ($this->updateUsername()) {
					$this->send('success', null);
					return true;
				}
			}
		}
		$this->send('error', 'error occured [2]');
		return false;
	}

	private function updateUsername ()
	{
		$db = new Bdd();

		$update = $db->getBdd()->prepare('UPDATE users SET username = ? WHERE id = ? AND token = ? AND active = 1');
		$update->bindParam(1, $_POST['username']);
		$update->bindParam(2, $_SESSION['id']);
		$update->bindParam(3, $_SESSION['token']);
		return $update->execute();
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