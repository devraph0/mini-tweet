<?php
namespace controllers;

use models\Bdd;
use models\Model;
class TweetsController extends Model
{
	public function __construct ()
	{
		if (isset($_POST['to'])) {
			switch ($_POST['to']) {
				case 'send-tweet':
					$this->create();
					break;
				case 'update-tweet':
					$this->update();
					break;
			}
		}

		if (isset($_GET['delete'])) {
			$this->delete();
		}
	}

	public function create ()
	{
		$db = new Bdd();

		if (strlen($_POST['tweet']) > 120) {
			return $this->send('error', 'you send more than 120 letters');
		}
		$create = $db->getBdd()->prepare('INSERT INTO tweets (content, user_id, created_at) VALUES (?, ?, NOW())');
		$create->bindParam(1, $_POST['tweet']);
		$create->bindParam(2, $_SESSION['id']);
		if ($create->execute()) {
			return $this->send('success', null);
		}
	}

	public function read ()
	{

	}

	public function get ()
	{
		$db = new Bdd();

		$page = 0;
		if (isset($_GET['page']) && is_numeric($_GET['page'])) {
			$page = intval($_GET['page']) - 1;
		}
		$offset = (int) $page * 3;

		$get = $db->getBdd()->prepare('SELECT id, content, created_at, updated_at FROM tweets WHERE user_id = ? AND active = 1 ORDER BY id DESC LIMIT 3 OFFSET ' . $offset);
		$get->bindParam(1, $_SESSION['id']);
		if ($get->execute()) {
			$all = $get->fetchAll(\PDO::FETCH_ASSOC);
			return $all;
		}

		return false;
	}
	public function count()
	{
		$db = new Bdd();

		$count = $db->getBdd()->prepare('SELECT count(id) AS nb FROM tweets WHERE user_id = ? AND active = 1');
		$count->bindParam(1, $_SESSION['id']);
		if ($count->execute()) {
			$nb = $count->fetch(\PDO::FETCH_ASSOC)['nb'];
			return ceil($nb / 3);
		}
		return false;
	}

	public function update ()
	{
		$db = new Bdd();
		if (strlen($_POST['tweet']) > 120) {
			return $this->send('error', 'you send more than 120 letters');
		}
		$update = $db->getBdd()->prepare('UPDATE tweets SET content = ?, updated_at = NOW() WHERE user_id = ? AND active = 1 AND id = ?');
		$update->bindParam(1, $_POST['tweet']);
		$update->bindParam(2, $_SESSION['id']);
		$update->bindParam(3, $_POST['id']);
		if ($update->execute()) {
			return $this->send('success', null);
		} else {
			return $this->send('error', 'error occured [4]');
		}
	}

	public function delete ()
	{
		$db = new Bdd();

		$verif = $db->getBdd()->prepare('SELECT id FROM tweets WHERE active = 1 AND user_id = ? AND id = ?');
		$verif->bindParam(1, $_SESSION['id']);
		$verif->bindParam(2, $_GET['delete']);
		$verif->execute();

		if (!$verif->fetchAll()) {
			return $this->send('error', 'nice try bad boy lol');
		}

		$delete = $db->getBdd()->prepare('UPDATE tweets SET active = 0 WHERE user_id = ? AND active = 1 AND id = ?');
		$delete->bindParam(1, $_SESSION['id']);
		$delete->bindParam(2, $_GET['delete']);
		if ($delete->execute()) {
			return $this->send('success', null);
		}


	}
}