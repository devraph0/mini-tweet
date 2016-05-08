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
			}
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

		$get = $db->getBdd()->prepare('SELECT content, created_at, updated_at FROM tweets WHERE user_id = ? AND active = 1 ORDER BY id DESC');
		$get->bindParam(1, $_SESSION['id']);
		if ($get->execute()) {
			$all = $get->fetchAll(\PDO::FETCH_ASSOC);
			return $all;
		}

		return false;
	}

	public function update ()
	{

	}

	public function delete ()
	{

	}
}