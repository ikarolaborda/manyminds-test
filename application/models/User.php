<?php

require_once APPPATH.'models/UserModelInterface.php';

class User extends CI_Model implements UserModelInterface
{

	protected $pdo;

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$dsn = 'mysql:host='.$this->db->hostname.';dbname='.$this->db->database.';charset=utf8mb4';
		$this->pdo = new PDO(
			$dsn,
			$this->db->username,
			$this->db->password,
			array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}

	/* Poderiam ser usadas queries do active record/query builder do CI, mas o roteiro do teste diz que nao se deve utilizar ORMs */
	public function create(array $data): int {
		$stmt = $this->pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
		$stmt->execute(array(
			'username' => $data['username'],
			'email' => $data['email'],
			'password' => password_hash($data['password'], PASSWORD_DEFAULT)));
		return $this->pdo->lastInsertId();
	}

	public function read(?int $id): ?array {
		if ($id) {
			$stmt = $this->pdo->prepare("SELECT id, username, email FROM users WHERE id = :id");
			$stmt->execute(array('id' => $id));
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}
		$stmt = $this->pdo->prepare("SELECT id, username, email FROM users");
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function update(int $id, array $data): bool {
		/* Verificamos o array de dados para atualizar o usuario em cada caso */
		switch ($data) {
			case isset($data['username']) && isset($data['email']) && isset($data['password']):
				$stmt = $this->pdo->prepare("UPDATE users SET username = :username, email = :email, password = :password WHERE id = :id");
				$stmt->execute(array(
					'username' => $data['username'],
					'email' => $data['email'],
					'password' => password_hash($data['password'], PASSWORD_DEFAULT),
					'id' => $id));
				break;
			case isset($data['username']) && isset($data['email']):
				$stmt = $this->pdo->prepare("UPDATE users SET username = :username, email = :email WHERE id = :id");
				$stmt->execute(array(
					'username' => $data['username'],
					'email' => $data['email'],
					'id' => $id));
				break;
			case isset($data['username']) && isset($data['password']):
				$stmt = $this->pdo->prepare("UPDATE users SET username = :username, password = :password WHERE id = :id");
				$stmt->execute(array(
					'username' => $data['username'],
					'password' => password_hash($data['password'], PASSWORD_DEFAULT),
					'id' => $id));
				break;
			case isset($data['email']) && isset($data['password']):
				$stmt = $this->pdo->prepare("UPDATE users SET email = :email, password = :password WHERE id = :id");
				$stmt->execute(array(
					'email' => $data['email'],
					'password' => password_hash($data['password'], PASSWORD_DEFAULT),
					'id' => $id));
				break;
			case isset($data['username']):
				$stmt = $this->pdo->prepare("UPDATE users SET username = :username WHERE id = :id");
				$stmt->execute(array(
					'username' => $data['username'],
					'id' => $id));
				break;
			case isset($data['email']):
				$stmt = $this->pdo->prepare("UPDATE users SET email = :email WHERE id = :id");
				$stmt->execute(array(
					'email' => $data['email'],
					'id' => $id));
				break;
			case isset($data['password']):
				$stmt = $this->pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
				$stmt->execute(array(
					'password' => password_hash($data['password'], PASSWORD_DEFAULT),
					'id' => $id));
				break;
		}

		return $stmt->rowCount() > 0;

		/*Esse cenário não é o ideal e pode ser bastante melhorado se usarmos o match do php 8+ ou o eloquent ORM */
	}

	public function delete(int $id): bool {
		$query = $this->db->query("DELETE FROM users WHERE id = ?", array($id));
		return $this->db->affected_rows() > 0;
	}
}
