<?php

namespace App\Repositories\Interfaces;

interface TaskRepositoryInterface
{
    public function getAllTasks($userId);
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
