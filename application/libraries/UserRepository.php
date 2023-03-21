<?php

require_once APPPATH.'libraries/Repository.php';
class UserRepository extends Repository {
	protected $table = "users";
	protected $db;
	public function __construct() {
		$this->db = getDbConnection();
		$this->table = "users";
		parent::__construct($this->db, $this->table);

	}

	public function findByEmail(string $email): ?array {
		$stmt = $this->db->prepare("SELECT * FROM $this->table WHERE email = :email");
		$stmt->execute([':email' => $email]);
		return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
	}

	public function findByUsername(string $username): ?array {
		$stmt = $this->db->prepare("SELECT * FROM $this->table WHERE username = :username");
		$stmt->execute([':username' => $username]);
		return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
	}

	public function findByToken(string $token): ?array {
		$stmt = $this->db->prepare("SELECT * FROM $this->table WHERE token = :token");
		$stmt->execute([':token' => $token]);
		return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
	}

	public function findAll(): array
	{
		return $this->getAll();
	}

	public function findById(int $id): ?array
	{
		return $this->getById($id);
	}
}
