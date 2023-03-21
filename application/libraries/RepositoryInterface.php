<?php

interface RepositoryInterface {
	public function findAll(): array;
	public function findById(int $id): ?array;
	public function create(array $data): int;
	public function update(int $id, array $data): int;
	public function delete(int $id): int;
}
