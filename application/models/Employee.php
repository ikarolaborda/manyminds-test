<?php

class Employee extends CI_Model implements EmployeeModelInterface
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
		$stmt = $this->pdo->query("SELECT * FROM employees");
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($employee): int
    {
		$stmt = $this->pdo->prepare("INSERT INTO employees (employee_number, name, department_id, employee_CPF, employee_status, user_id) VALUES (?, ?, ?, ?, ?, ?)");
		$stmt->execute([$employee->employee_number, $employee->name, $employee->department_id, $employee->employee_CPF, $employee->employee_status, $employee->user_id]);
		return $this->pdo->lastInsertId();
    }

    public function read($id): array
    {
		$stmt = $this->pdo->prepare("SELECT * FROM employees WHERE id = ?");
		$stmt->execute([$id]);
		return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($employee): bool
    {
		$stmt = $this->pdo->prepare("UPDATE employees SET employee_number = ?, name = ?, department_id = ?, employee_CPF = ?, employee_status = ?, user_id = ? WHERE id = ?");
		return $stmt->execute([$employee->employee_number, $employee->name, $employee->department_id, $employee->employee_CPF, $employee->employee_status, $employee->user_id, $employee->id]);
    }

    public function delete($id): bool
    {
		$stmt = $this->pdo->prepare("DELETE FROM employees WHERE id = ?");
		return $stmt->execute([$id]);
    }
}
