<?php

namespace App\Repositories\Contracts;

interface BaseRepository
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function searchAndFilter(array $filters);
}
