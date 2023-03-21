<?php

require_once APPPATH.'models/UserModelInterface.php';
class UserModel implements UserModelInterface
{
	private $repository;

	public function __construct(UserRepository $repository)
	{
		$this->repository = $repository;
	}

	public function findAll(): array
	{
		return $this->repository->findAll();
	}

	public function findById(int $id): ?array
	{
		return $this->repository->findById($id);
	}

	public function create(array $data): int
	{
		return $this->repository->create($data);
	}

	public function update(int $id, array $data): bool
	{
		return $this->repository->update($id, $data);
	}

	public function delete(int $id): bool
	{
		return $this->repository->delete($id);
	}

	public function read(int $id): ?array
	{
		return $this->repository->getById($id);
	}
}
