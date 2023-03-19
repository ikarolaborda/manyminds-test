<?php

interface EmployeeModelInterface {
	public function getAll(): array;
	public function create($employee): int;
	public function read($id): array;
	public function update($employee): bool;
	public function delete($id): bool;
}
