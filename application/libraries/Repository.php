<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once './system/core/Model.php';
require_once APPPATH.'libraries/RepositoryInterface.php';
abstract class Repository extends CI_Model implements RepositoryInterface{

	protected $table;
	protected $db;

	public function __construct($db, $table)
	{
		parent::__construct();
		$this->db = $db;
		$this->table = $table;
	}

	public function getAll()
	{
		$sql = sprintf('SELECT * FROM %s', $this->table);
		$stmt = $this->db->query($sql);
		return $stmt->fetchAll();
	}

	public function getById($id)
	{
		$sql = sprintf('SELECT * FROM %s WHERE id = :id', $this->table);
		$stmt = $this->db->query($sql, ['id' => $id]);
		return $stmt->fetch();
	}

	public function create($data): int
	{
		$keys = array_keys($data);
		$values = array_values($data);
		$sql = sprintf('INSERT INTO %s (%s) VALUES (%s)', $this->table, implode(',', $keys), implode(',', array_fill(0, count($values), '?')));
		$this->db->query($sql, $values);
		return $this->db->getLastInsertId();
	}

	public function update($id, $data): int
	{
		$sets = [];
		foreach ($data as $key => $value) {
			$sets[] = sprintf('%s = ?', $key);
		}
		$values = array_values($data);
		$values[] = $id;
		$sql = sprintf('UPDATE %s SET %s WHERE id = ?', $this->table, implode(',', $sets));
		$stmt = $this->db->query($sql, $values);
		return $stmt->rowCount();
	}

	public function delete($id): int
	{
		$sql = sprintf('DELETE FROM %s WHERE id = ?', $this->table);
		$stmt = $this->db->query($sql, [$id]);
		return $stmt->rowCount();
	}

}
