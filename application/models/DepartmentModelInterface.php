<?php

interface DepartmentModelInterface
{
	public function getAll(): array;
	public function create($department): int;
	public function read($id): ?array;
	public function update($department): bool;
	public function delete($id): bool;

}
