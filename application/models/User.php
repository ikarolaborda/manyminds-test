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
			return $this->db->query("SELECT * FROM users WHERE id = ?", array($id))->row_array();
		}
		return $this->db->query("SELECT * FROM users")->row_array();
	}

	public function update(int $id, array $data): bool {
		$query = $this->db->query("UPDATE users SET email = ?, password = ? WHERE id = ?", array($data['email'], $data['password'], $id));
		return $this->db->affected_rows() > 0;
	}

	public function delete(int $id): bool {
		$query = $this->db->query("DELETE FROM users WHERE id = ?", array($id));
		return $this->db->affected_rows() > 0;
	}
}
