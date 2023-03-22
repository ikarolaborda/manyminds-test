<?php

require_once APPPATH.'models/ProductModelInterface.php';
class Product extends CI_Model implements ProductModelInterface
{

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

	public function create(array $data): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO products (name, description, price, slug, image_url) VALUES (:name, :description, :price, :slug, :image_url)");
		$stmt->execute(array(
			'name' => $data['name'],
			'description' => $data['description'],
			'price' => $data['price'],
			'slug' => $data['slug'],
			'image_url' => $data['image_url']));
		return $this->pdo->lastInsertId();
    }

    public function read(?int $id): ?array
    {
        if ($id) {
			$stmt = $this->pdo->prepare("SELECT id, name, description, price, slug, image_url FROM products WHERE id = :id");
			$stmt->execute(array('id' => $id));
			return $stmt->fetch(PDO::FETCH_ASSOC);
		}
		$stmt = $this->pdo->prepare("SELECT id, name, description, price, slug, image_url FROM products");
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update(int $id, array $data): bool
    {
        switch ($data) {
			case isset($data['name']) && isset($data['description']) && isset($data['price']) && isset($data['slug']) && isset($data['image_url']):
				$stmt = $this->pdo->prepare("UPDATE products SET name = :name, description = :description, price = :price, slug = :slug, image_url = :image_url WHERE id = :id");
				$stmt->execute(array(
					'name' => $data['name'],
					'description' => $data['description'],
					'price' => $data['price'],
					'slug' => $data['slug'],
					'image_url' => $data['image_url'],
					'id' => $id));
				break;
			case isset($data['name']) && isset($data['description']) && isset($data['price']) && isset($data['slug']):
				$stmt = $this->pdo->prepare("UPDATE products SET name = :name, description = :description, price = :price, slug = :slug WHERE id = :id");
				$stmt->execute(array(
					'name' => $data['name'],
					'description' => $data['description'],
					'price' => $data['price'],
					'slug' => $data['slug'],
					'id' => $id));
				break;
			case isset($data['name']) && isset($data['description']) && isset($data['price']):
				$stmt = $this->pdo->prepare("UPDATE products SET name = :name, description = :description, price = :price WHERE id = :id");
				$stmt->execute(array(
					'name' => $data['name'],
					'description' => $data['description'],
					'price' => $data['price'],
					'id' => $id));
				break;
			case isset($data['name']) && isset($data['description']):
				$stmt = $this->pdo->prepare("UPDATE products SET name = :name, description = :description WHERE id = :id");
				$stmt->execute(array(
					'name' => $data['name'],
					'description' => $data['description'],
					'id' => $id));
				break;
			case isset($data['name']):
				$stmt = $this->pdo->prepare("UPDATE products SET name = :name WHERE id = :id");
				$stmt->execute(array(
					'name' => $data['name'],
					'id' => $id));
				break;
			default:
				return false;
		}

		return $stmt->rowCount() > 0;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = :id");
		$stmt->execute(array('id' => $id));
		return $stmt->rowCount() > 0;
    }
}
