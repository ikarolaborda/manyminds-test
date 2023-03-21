<?php

class Product extends CI_Model implements ProductModelInterface
{
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

	public function findAll(): array {
		$stmt = $this->db->prepare("SELECT * FROM products");
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function findById(int $id): ?array {
		$stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id");
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
	}

	public function create(array $data): int {
		$stmt = $this->db->prepare("INSERT INTO products (name, price) VALUES (:name, :price)");
		$stmt->bindParam(':name', $data['name']);
		$stmt->bindParam(':price', $data['price']);
		$stmt->execute();
		return $this->db->lastInsertId();
	}

	public function update(int $id, array $data): bool {
		$stmt = $this->db->prepare("UPDATE products SET name = :name, price = :price WHERE id = :id");
		$stmt->bindParam(':name', $data['name']);
		$stmt->bindParam(':price', $data['price']);
		$stmt->bindParam(':id', $id);
		return $stmt->execute();
	}

	public function delete(int $id): bool {
		$stmt = $this->db->prepare("DELETE FROM products WHERE id = :id");
		$stmt->bindParam(':id', $id);
		return $stmt->execute();
	}

}
