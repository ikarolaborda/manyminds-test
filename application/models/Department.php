<?php

class Department extends CI_Model implements DepartmentModelInterface
{
	protected PDO $pdo; // Caso estivessemos a usar o PHP 8+, poderíamos usar o constructor property promotion, sem precisar de declarar a variável $pdo

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$dsn = 'mysql:host='.$this->db->hostname.';dbname='.$this->db->database.';charset=utf8mb4';
		$this->pdo = new PDO(
			$dsn,
			$this->db->username,
			$this->db->password,
			array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}

	public function getAll(): array
    {
		$stmt = $this->pdo->query("SELECT * FROM departments");
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($department): int
    {
		$stmt = $this->pdo->prepare("INSERT INTO departments (name) VALUES (?)");
		$stmt->execute([$department->name]);
		return (int) $this->pdo->lastInsertId();
    }

    public function read($id): ?array
    {
		$stmt = $this->pdo->prepare("SELECT * FROM departments WHERE id = ?");
		$stmt->execute([$id]);
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		return $result ? $result : null;
    }

    public function update($department): bool
    {
		$stmt = $this->pdo->prepare("UPDATE departments SET name = ? WHERE id = ?");
		return $stmt->execute([$department->name, $department->id]);
    }

    public function delete($id): bool
    {
		$stmt = $this->pdo->prepare("DELETE FROM departments WHERE id = ?");
		return $stmt->execute([$id]);
    }
}
